<?php

namespace App\Http\Controllers;

use App\Exports\StockOutExport;
use App\Models\Material;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class StockOutController extends Controller
{
    /**
     * Tampilkan halaman utama Stok Keluar:
     * Menampilkan daftar transaksi stok keluar, kartu statistik,
     * filter pencarian & tanggal, serta modal tambah, edit, dan hapus.
     */
    public function index(Request $request)
    {
        $search    = trim($request->input('search', ''));
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $perPage   = $request->input('per_page', 25);

        // Ambil semua material master data untuk pilihan dropdown form tambah
        $allMaterials = Material::orderBy('name', 'asc')->get();

        // Query transaksi stok keluar (aktivitas Keluar atau quantity_change negatif)
        $query = StockMovement::with(['material', 'user'])
            ->where(function ($q) {
                $q->where('activity', 'Keluar')
                  ->orWhere('quantity_change', '<', 0);
            });

        // Filter pencarian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('material_number', 'like', "%{$search}%")
                  ->orWhere('material_name', 'like', "%{$search}%")
                  ->orWhere('recipient', 'like', "%{$search}%")
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

        // Urutkan dari transaksi stok keluar terbaru
        $query->latest('created_at')->latest('id');

        // Statistik Cepat Stok Keluar
        $totalTransactions = (clone $query)->count();
        $totalQuantityOut  = abs((clone $query)->sum('quantity_change'));
        $totalMaterialsOut = (clone $query)->distinct('material_number')->count('material_number');

        // Pagination
        if ($perPage === 'all' || $perPage === 'Semua') {
            $perPageValue = $totalTransactions > 0 ? $totalTransactions : 25;
        } else {
            $perPageValue = in_array((int) $perPage, [10, 25, 50, 100, 250])
                ? (int) $perPage
                : 25;
        }

        $stockOuts = $query->paginate($perPageValue)->withQueryString();

        return view('materials.stock-out.index', compact(
            'stockOuts',
            'allMaterials',
            'totalTransactions',
            'totalQuantityOut',
            'totalMaterialsOut',
            'search',
            'startDate',
            'endDate',
            'perPage'
        ));
    }

    /**
     * Catat transaksi pengeluaran stok material baru (Stok Keluar).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity'    => 'required|integer|min:1',
            'exit_date'   => 'required|date',
            'recipient'   => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'material_id.required' => 'Pilih material yang akan dikeluarkan stoknya.',
            'material_id.exists'   => 'Material yang dipilih tidak ditemukan dalam sistem.',
            'quantity.required'    => 'Jumlah keluar wajib diisi.',
            'quantity.integer'     => 'Jumlah keluar harus berupa angka bulat.',
            'quantity.min'         => 'Jumlah keluar minimal 1.',
            'exit_date.required'   => 'Tanggal keluar wajib diisi.',
            'exit_date.date'       => 'Format tanggal keluar tidak valid.',
            'recipient.required'   => 'Penerima / Unit Tujuan wajib diisi.',
            'recipient.max'        => 'Penerima / Unit Tujuan maksimal 255 karakter.',
            'description.max'      => 'Keterangan maksimal 1000 karakter.',
        ]);

        $qtyOut = (int) $validated['quantity'];

        try {
            DB::transaction(function () use ($validated, $qtyOut) {
                // Lock material row untuk mencegah race condition
                $material = Material::lockForUpdate()->findOrFail($validated['material_id']);

                $currentQty = (int) $material->quantity;

                // Cegah stok melebihi stok yang tersedia
                if ($qtyOut > $currentQty) {
                    throw ValidationException::withMessages([
                        'quantity' => "Jumlah keluar ({$qtyOut} {$material->unit}) melebihi stok yang tersedia ({$currentQty} {$material->unit}).",
                    ]);
                }

                $newQty = $currentQty - $qtyOut;

                // Kurangi stok material
                $material->update([
                    'quantity' => $newQty,
                ]);

                // Tanggal dan waktu transaksi stok keluar
                $exitDateTime = Carbon::parse($validated['exit_date'])->setTime(
                    now()->hour,
                    now()->minute,
                    now()->second
                );

                // Catat ke riwayat pergerakan stok
                $movement = new StockMovement([
                    'material_id'     => $material->id,
                    'material_name'   => $material->name,
                    'material_number' => $material->material_number,
                    'user_id'         => Auth::id() ?? 1,
                    'activity'        => 'Keluar',
                    'quantity_before' => $currentQty,
                    'quantity_after'  => $newQty,
                    'quantity_change' => -$qtyOut,
                    'recipient'       => trim($validated['recipient']),
                    'description'     => !empty($validated['description']) ? trim($validated['description']) : null,
                ]);
                $movement->created_at = $exitDateTime;
                $movement->save();
            });

            $materialName = Material::find($validated['material_id'])->name ?? 'Material';

            return redirect()
                ->route('materials.stock-out.index')
                ->with('success', "Stok keluar material \"{$materialName}\" sebanyak {$qtyOut} unit berhasil dicatat.");
        } catch (ValidationException $ve) {
            throw $ve;
        } catch (\Exception $e) {
            return redirect()
                ->route('materials.stock-out.index')
                ->with('error', 'Gagal memproses stok keluar: ' . $e->getMessage());
        }
    }

    /**
     * Perbarui data transaksi stok keluar dan hitung ulang stok material secara konsisten.
     */
    public function update(Request $request, StockMovement $stockMovement)
    {
        $validated = $request->validate([
            'quantity'    => 'required|integer|min:1',
            'exit_date'   => 'required|date',
            'recipient'   => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'quantity.required'  => 'Jumlah keluar wajib diisi.',
            'quantity.integer'   => 'Jumlah keluar harus berupa angka bulat.',
            'quantity.min'       => 'Jumlah keluar minimal 1.',
            'exit_date.required' => 'Tanggal keluar wajib diisi.',
            'exit_date.date'     => 'Format tanggal keluar tidak valid.',
            'recipient.required' => 'Penerima / Unit Tujuan wajib diisi.',
            'recipient.max'      => 'Penerima / Unit Tujuan maksimal 255 karakter.',
            'description.max'    => 'Keterangan maksimal 1000 karakter.',
        ]);

        $newQtyOut = (int) $validated['quantity'];

        try {
            DB::transaction(function () use ($stockMovement, $validated, $newQtyOut) {
                // Lock data pergerakan stok
                $movement = StockMovement::lockForUpdate()->findOrFail($stockMovement->id);

                if ($movement->activity !== 'Keluar' && $movement->quantity_change >= 0) {
                    throw new \Exception('Hanya transaksi stok keluar yang dapat diedit melalui halaman ini.');
                }

                $oldQtyOut = abs((int) $movement->quantity_change);

                // Cek material terkait
                $material = null;
                if ($movement->material_id) {
                    $material = Material::lockForUpdate()->find($movement->material_id);
                }

                $qtyBefore = $movement->quantity_before;
                $qtyAfter  = $movement->quantity_after;

                if ($material) {
                    // Hitung total stok yang tersedia jika transaksi lama dibatalkan / dikembalikan
                    $availableStock = (int) $material->quantity + $oldQtyOut;

                    if ($newQtyOut > $availableStock) {
                        throw ValidationException::withMessages([
                            'quantity' => "Jumlah keluar ({$newQtyOut} {$material->unit}) melebihi stok yang tersedia ({$availableStock} {$material->unit}).",
                        ]);
                    }

                    $newMaterialQty = $availableStock - $newQtyOut;
                    $material->update([
                        'quantity' => $newMaterialQty,
                    ]);

                    $qtyBefore = $availableStock;
                    $qtyAfter  = $newMaterialQty;
                }

                // Waktu transaksi
                $exitTime = $movement->created_at ? $movement->created_at : now();
                $exitDateTime = Carbon::parse($validated['exit_date'])->setTime(
                    $exitTime->hour,
                    $exitTime->minute,
                    $exitTime->second
                );

                // Perbarui record transaksi pergerakan stok
                $movement->update([
                    'quantity_before' => $qtyBefore,
                    'quantity_after'  => $qtyAfter,
                    'quantity_change' => -$newQtyOut,
                    'recipient'       => trim($validated['recipient']),
                    'description'     => !empty($validated['description']) ? trim($validated['description']) : null,
                    'created_at'      => $exitDateTime,
                ]);
            });

            return redirect()
                ->route('materials.stock-out.index')
                ->with('success', "Transaksi stok keluar material \"{$stockMovement->material_name}\" berhasil diperbarui.");
        } catch (ValidationException $ve) {
            throw $ve;
        } catch (\Exception $e) {
            return redirect()
                ->route('materials.stock-out.index')
                ->with('error', 'Gagal memperbarui transaksi stok keluar: ' . $e->getMessage());
        }
    }

    /**
     * Hapus transaksi stok keluar dan kembalikan stok material ke jumlah semula.
     */
    public function destroy(StockMovement $stockMovement)
    {
        try {
            DB::transaction(function () use ($stockMovement) {
                $movement = StockMovement::lockForUpdate()->findOrFail($stockMovement->id);

                if ($movement->activity !== 'Keluar' && $movement->quantity_change >= 0) {
                    throw new \Exception('Hanya transaksi stok keluar yang dapat dihapus melalui halaman ini.');
                }

                $qtyToRestore = abs((int) $movement->quantity_change);

                // Kembalikan stok ke material jika material masih ada
                if ($movement->material_id) {
                    $material = Material::lockForUpdate()->find($movement->material_id);
                    if ($material) {
                        $material->update([
                            'quantity' => (int) $material->quantity + $qtyToRestore,
                        ]);
                    }
                }

                // Hapus data riwayat transaksi pergerakan stok
                $movement->delete();
            });

            return redirect()
                ->route('materials.stock-out.index')
                ->with('success', "Transaksi stok keluar material \"{$stockMovement->material_name}\" berhasil dihapus dan stok material telah dikembalikan.");
        } catch (\Exception $e) {
            return redirect()
                ->route('materials.stock-out.index')
                ->with('error', 'Gagal menghapus transaksi stok keluar: ' . $e->getMessage());
        }
    }

    /**
     * Ekspor data riwayat transaksi stok keluar ke format Excel.
     */
    public function export(Request $request)
    {
        return Excel::download(
            new StockOutExport(
                $request->input('search'),
                $request->input('start_date'),
                $request->input('end_date'),
                $request->input('per_page'),
                $request->input('page')
            ),
            'laporan-stok-keluar-atk.xlsx'
        );
    }
}
