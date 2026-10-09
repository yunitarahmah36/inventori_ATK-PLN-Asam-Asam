<?php

namespace App\Http\Controllers;

use App\Exports\StockInTemplateExport;
use App\Imports\StockInImport;
use App\Models\Material;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class StockInController extends Controller
{
    /**
     * Tampilkan halaman utama Stok Masuk:
     * Menampilkan daftar riwayat pergerakan stok masuk, statistik,
     * serta modal form input manual dan import Excel.
     */
    public function index(Request $request)
    {
        $search    = trim($request->input('search', ''));
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $perPage   = $request->input('per_page', 25);

        // Ambil semua material master data untuk pilihan dropdown form manual
        $allMaterials = Material::orderBy('name', 'asc')->get();

        // Query pergerakan stok masuk (aktivitas Tambah atau perubahan stok positif)
        $query = StockMovement::with(['material', 'user'])
            ->where(function ($q) {
                $q->where('activity', 'Tambah')
                  ->orWhere('quantity_change', '>', 0);
            });

        // Filter pencarian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('material_number', 'like', "%{$search}%")
                  ->orWhere('material_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter rentang tanggal
        if (!empty($startDate)) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if (!empty($endDate)) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Urutkan dari transaksi stok masuk terbaru
        $query->latest('created_at')->latest('id');

        // Statistik Cepat Stok Masuk
        $totalTransactions = (clone $query)->count();
        $totalQuantityIn   = (clone $query)->sum('quantity_change');
        $totalMaterialsIn  = (clone $query)->distinct('material_number')->count('material_number');

        // Pagination
        if ($perPage === 'all' || $perPage === 'Semua') {
            $perPageValue = $totalTransactions > 0 ? $totalTransactions : 25;
        } else {
            $perPageValue = in_array((int) $perPage, [10, 25, 50, 100, 250])
                ? (int) $perPage
                : 25;
        }

        $stockIns = $query->paginate($perPageValue)->withQueryString();

        return view('materials.stock-in.index', compact(
            'stockIns',
            'allMaterials',
            'totalTransactions',
            'totalQuantityIn',
            'totalMaterialsIn',
            'search',
            'startDate',
            'endDate',
            'perPage'
        ));
    }

    /**
     * Catat penambahan stok material secara manual untuk satu material.
     */
    public function storeManual(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity'    => 'required|integer|min:1',
            'entry_date'  => 'required|date',
            'description' => 'required|string|max:1000',
        ], [
            'material_id.required' => 'Pilih material yang akan ditambah stoknya.',
            'material_id.exists'   => 'Material yang dipilih belum terdaftar di Data Material.',
            'quantity.required'    => 'Jumlah masuk wajib diisi.',
            'quantity.integer'     => 'Jumlah masuk harus berupa angka bulat.',
            'quantity.min'         => 'Jumlah masuk wajib lebih dari 0.',
            'entry_date.required'  => 'Tanggal masuk wajib diisi.',
            'entry_date.date'      => 'Format tanggal masuk tidak valid.',
            'description.required' => 'Keterangan atau sumber stok masuk wajib diisi.',
            'description.max'      => 'Keterangan maksimal 1000 karakter.',
        ]);

        $qtyIn = (int) $validated['quantity'];

        try {
            DB::transaction(function () use ($validated, $qtyIn) {
                // Kunci data material untuk menjaga konsistensi
                $material = Material::lockForUpdate()->findOrFail($validated['material_id']);

                $qtyBefore = (int) $material->quantity;
                $qtyAfter  = $qtyBefore + $qtyIn;

                // Tanggal dan waktu pergerakan stok
                $entryDateTime = Carbon::parse($validated['entry_date'])->setTime(
                    now()->hour,
                    now()->minute,
                    now()->second
                );

                // Update kuantitas stok material dan perbarui tanggal masuk
                $material->update([
                    'quantity'   => $qtyAfter,
                    'entry_date' => $validated['entry_date'],
                ]);

                // Catat ke Riwayat Pergerakan Material dengan tanggal pergerakan yang valid
                $movement = new StockMovement([
                    'material_id'     => $material->id,
                    'material_name'   => $material->name,
                    'material_number' => $material->material_number,
                    'user_id'         => Auth::id(),
                    'activity'        => 'Tambah',
                    'quantity_before' => $qtyBefore,
                    'quantity_after'  => $qtyAfter,
                    'quantity_change' => $qtyIn,
                    'description'     => trim($validated['description']),
                ]);
                $movement->created_at = $entryDateTime;
                $movement->save();
            });

            $materialName = Material::find($validated['material_id'])->name ?? 'Material';

            return redirect()
                ->route('materials.stock-in.index')
                ->with('success', "Stok masuk material \"{$materialName}\" sebanyak {$qtyIn} unit berhasil dicatat.");
        } catch (\Illuminate\Validation\ValidationException $ve) {
            throw $ve;
        } catch (\Exception $e) {
            return redirect()
                ->route('materials.stock-in.index')
                ->with('error', 'Gagal memproses stok masuk: ' . $e->getMessage());
        }
    }

    /**
     * Import penambahan stok masuk untuk banyak material sekaligus via Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ], [
            'file.required' => 'Pilih file Excel yang akan diimport.',
            'file.file'     => 'File yang diunggah tidak valid.',
            'file.mimes'    => 'Format file harus berupa Excel (.xlsx, .xls) atau CSV.',
            'file.max'      => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            $importer = new StockInImport();
            Excel::import($importer, $request->file('file'));

            return redirect()
                ->route('materials.stock-in.index')
                ->with('success', "Berhasil mengimport stok masuk: {$importer->processedRowsCount} baris data diproses untuk {$importer->affectedMaterialsCount} jenis material.");
        } catch (ValidationException $e) {
            // Re-throw agar error ditampilkan di flash validation
            throw $e;
        } catch (\Exception $e) {
            return redirect()
                ->route('materials.stock-in.index')
                ->with('error', 'Gagal memproses file import: ' . $e->getMessage());
        }
    }

    /**
     * Unduh template file Excel untuk Stok Masuk.
     */
    public function downloadTemplate()
    {
        return Excel::download(
            new StockInTemplateExport(),
            'template-stok-masuk-atk.xlsx'
        );
    }
}
