<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MaterialController extends Controller
{
    /**
     * Tampilkan daftar material dengan pencarian, filter tanggal, dan pagination.
     */
    public function index(Request $request)
    {
        $search    = trim($request->input('search', ''));
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $perPage   = $request->input('per_page', 25);

        $query = Material::query();

        // Pencarian berdasarkan No Material atau Nama Material
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('material_number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Filter tanggal masuk (entry_date)
        if (!empty($startDate)) {
            $query->whereDate('entry_date', '>=', $startDate);
        }

        if (!empty($endDate)) {
            $query->whereDate('entry_date', '<=', $endDate);
        }

        // Urutkan dari yang terbaru
        $query->latest('entry_date')->latest('id');

        // Total data sesuai filter saat ini
        $totalFiltered = (clone $query)->count();

        // Pagination sesuai dropdown
        if ($perPage === 'all' || $perPage === 'Semua') {
            $perPageValue = $totalFiltered > 0 ? $totalFiltered : 25;
        } else {
            $perPageValue = in_array((int)$perPage, [10, 25, 50, 100, 250]) ? (int)$perPage : 25;
        }

        $materials = $query->paginate($perPageValue)->withQueryString();

        return view('materials.index', compact(
            'materials',
            'search',
            'startDate',
            'endDate',
            'perPage',
            'totalFiltered'
        ));
    }

    /**
     * Tampilkan form penambahan material baru.
     */
    public function create()
    {
        // Generate saran No Material otomatis (misal MAT005)
        $latestMaterial = Material::orderBy('id', 'desc')->first();
        $suggestedNumber = 'MAT001';

        if ($latestMaterial && preg_match('/^MAT(\d+)$/i', $latestMaterial->material_number, $matches)) {
            $nextNum = ((int)$matches[1]) + 1;
            $suggestedNumber = 'MAT' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
        }

        return view('materials.create', compact('suggestedNumber'));
    }

    /**
     * Simpan material baru ke database dan catat riwayat stok.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_number' => 'required|string|max:50|unique:materials,material_number',
            'name'            => 'required|string|max:255',
            'entry_date'      => 'required|date',
            'quantity'        => 'required|integer|min:0',
            'unit'            => 'required|string|max:50',
            'description'     => 'nullable|string|max:1000',
        ], [
            'material_number.required' => 'No Material wajib diisi.',
            'material_number.unique'   => 'No Material sudah digunakan, silakan gunakan nomor lain.',
            'name.required'            => 'Nama Material wajib diisi.',
            'entry_date.required'      => 'Tanggal Masuk wajib diisi.',
            'entry_date.date'          => 'Format tanggal tidak valid.',
            'quantity.required'        => 'Jumlah Item wajib diisi.',
            'quantity.integer'         => 'Jumlah Item harus berupa angka.',
            'quantity.min'             => 'Jumlah Item tidak boleh bernilai negatif.',
            'unit.required'            => 'Satuan wajib diisi.',
        ]);

        $material = Material::create([
            'material_number' => $validated['material_number'],
            'name'            => $validated['name'],
            'entry_date'      => $validated['entry_date'],
            'quantity'        => $validated['quantity'],
            'unit'            => $validated['unit'],
            'description'     => $validated['description'] ?? null,
            'created_by'      => Auth::id(),
        ]);

        // Catat riwayat aktivitas stok
        StockMovement::create([
            'material_id'     => $material->id,
            'user_id'         => Auth::id(),
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_after'  => $material->quantity,
            'quantity_change' => $material->quantity,
            'description'     => $validated['description'] ?: 'Penambahan material baru',
        ]);

        return redirect()->route('materials.index')
            ->with('success', 'Material berhasil ditambahkan.');
    }

    /**
     * Tampilkan form untuk mengedit material.
     */
    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    /**
     * Perbarui data material di database dan catat riwayat stok.
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'material_number' => 'required|string|max:50|unique:materials,material_number,' . $material->id,
            'name'            => 'required|string|max:255',
            'entry_date'      => 'required|date',
            'quantity'        => 'required|integer|min:0',
            'unit'            => 'required|string|max:50',
            'description'     => 'nullable|string|max:1000',
        ], [
            'material_number.required' => 'No Material wajib diisi.',
            'material_number.unique'   => 'No Material sudah digunakan, silakan gunakan nomor lain.',
            'name.required'            => 'Nama Material wajib diisi.',
            'entry_date.required'      => 'Tanggal Masuk wajib diisi.',
            'entry_date.date'          => 'Format tanggal tidak valid.',
            'quantity.required'        => 'Jumlah Item wajib diisi.',
            'quantity.integer'         => 'Jumlah Item harus berupa angka.',
            'quantity.min'             => 'Jumlah Item tidak boleh bernilai negatif.',
            'unit.required'            => 'Satuan wajib diisi.',
        ]);

        $qtyBefore = (int) $material->quantity;
        $qtyAfter  = (int) $validated['quantity'];
        $qtyChange = $qtyAfter - $qtyBefore;

        $material->update([
            'material_number' => $validated['material_number'],
            'name'            => $validated['name'],
            'entry_date'      => $validated['entry_date'],
            'quantity'        => $qtyAfter,
            'unit'            => $validated['unit'],
            'description'     => $validated['description'] ?? null,
        ]);

        // Catat riwayat aktivitas stok
        StockMovement::create([
            'material_id'     => $material->id,
            'user_id'         => Auth::id(),
            'activity'        => 'Edit',
            'quantity_before' => $qtyBefore,
            'quantity_after'  => $qtyAfter,
            'quantity_change' => $qtyChange,
            'description'     => $qtyChange !== 0
                ? "Penyesuaian stok ({$qtyChange} {$material->unit})"
                : 'Pembaruan informasi data material',
        ]);

        return redirect()->route('materials.index')
            ->with('success', 'Material berhasil diperbarui.');
    }

    /**
     * Hapus material dari database.
     */
    public function destroy(Material $material)
    {
        $materialName = $material->name;
        $material->delete();

        return redirect()->route('materials.index')
            ->with('success', "Material {$materialName} berhasil dihapus.");
    }

    /**
     * Export data material ke file Excel (CSV kompatibel).
     */
    public function export(Request $request)
    {
        $search    = trim($request->input('search', ''));
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        $query = Material::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('material_number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if (!empty($startDate)) {
            $query->whereDate('entry_date', '>=', $startDate);
        }

        if (!empty($endDate)) {
            $query->whereDate('entry_date', '<=', $endDate);
        }

        $materials = $query->latest('entry_date')->latest('id')->get();

        $filename = 'Data_Material_ATK_PLN_' . date('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () use ($materials) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM untuk kompatibilitas Microsoft Excel
            fputs($handle, "\xEF\xBB\xBF");

            // Header kolom
            fputcsv($handle, [
                'No',
                'No Material',
                'Nama Material',
                'Tanggal Masuk',
                'Jumlah Item',
                'Satuan',
                'Deskripsi'
            ], ';');

            $no = 1;
            foreach ($materials as $mat) {
                fputcsv($handle, [
                    $no++,
                    $mat->material_number,
                    $mat->name,
                    $mat->entry_date ? $mat->entry_date->format('d/m/Y') : '-',
                    $mat->quantity,
                    $mat->unit,
                    $mat->description ?? '-'
                ], ';');
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    /**
     * Tampilan awal untuk Import Excel (placeholder yang rapi).
     */
    public function importForm()
    {
        return view('materials.import');
    }
}
