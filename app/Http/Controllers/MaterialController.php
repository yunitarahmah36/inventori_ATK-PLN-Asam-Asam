<?php

namespace App\Http\Controllers;

use App\Exports\MaterialsExport;
use App\Models\Material;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MaterialsImport;
use App\Exports\MaterialsTemplateExport;

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

        // Filter tanggal masuk
        if (!empty($startDate)) {
            $query->whereDate('entry_date', '>=', $startDate);
        }

        if (!empty($endDate)) {
            $query->whereDate('entry_date', '<=', $endDate);
        }

        // Urutkan dari yang terbaru
        $query->latest('entry_date')->latest('id');

        // Total data sesuai filter
        $totalFiltered = (clone $query)->count();

        // Pagination sesuai dropdown
        if ($perPage === 'all' || $perPage === 'Semua') {
            $perPageValue = $totalFiltered > 0 ? $totalFiltered : 25;
        } else {
            $perPageValue = in_array(
                (int) $perPage,
                [10, 25, 50, 100, 250]
            )
                ? (int) $perPage
                : 25;
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
        // Generate saran No Material otomatis
        $latestMaterial = Material::orderBy('id', 'desc')->first();

        $suggestedNumber = 'MAT001';

        if (
            $latestMaterial &&
            preg_match(
                '/^MAT(\d+)$/i',
                $latestMaterial->material_number,
                $matches
            )
        ) {
            $nextNum = ((int) $matches[1]) + 1;

            $suggestedNumber = 'MAT' .
                str_pad($nextNum, 3, '0', STR_PAD_LEFT);
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
            'description'     => $validated['description']
                ?: 'Penambahan material baru',
        ]);

        return redirect()
            ->route('materials.index')
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
     * Perbarui data material dan catat riwayat stok.
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'material_number' =>
                'required|string|max:50|unique:materials,material_number,' .
                $material->id,

            'name'        => 'required|string|max:255',
            'entry_date'  => 'required|date',
            'quantity'    => 'required|integer|min:0',
            'unit'        => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
        ], [
            'material_number.required' =>
                'No Material wajib diisi.',

            'material_number.unique' =>
                'No Material sudah digunakan, silakan gunakan nomor lain.',

            'name.required' =>
                'Nama Material wajib diisi.',

            'entry_date.required' =>
                'Tanggal Masuk wajib diisi.',

            'entry_date.date' =>
                'Format tanggal tidak valid.',

            'quantity.required' =>
                'Jumlah Item wajib diisi.',

            'quantity.integer' =>
                'Jumlah Item harus berupa angka.',

            'quantity.min' =>
                'Jumlah Item tidak boleh bernilai negatif.',

            'unit.required' =>
                'Satuan wajib diisi.',
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

        return redirect()
            ->route('materials.index')
            ->with('success', 'Material berhasil diperbarui.');
    }

    /**
     * Hapus material dari database.
     */
    public function destroy(Material $material)
    {
        $materialName = $material->name;

        // Catat riwayat aktivitas stok
        StockMovement::create([
            'material_id'     => $material->id,
            'user_id'         => Auth::id(),
            'activity'        => 'Hapus',
            'quantity_before' => (int) $material->quantity,
            'quantity_after'  => 0,
            'quantity_change' => -((int) $material->quantity),
            'description'     => 'Material dihapus dari sistem',
        ]);

        $material->delete();

        return redirect()
            ->route('materials.index')
            ->with(
                'success',
                "Material {$materialName} berhasil dihapus."
            );
    }

    /**
     * Hapus beberapa material sekaligus (bulk delete).
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids) || !is_array($ids)) {
            return redirect()
                ->route('materials.index')
                ->with('error', 'Tidak ada material yang dipilih.');
        }

        $materials = Material::whereIn('id', $ids)->get();

        if ($materials->isEmpty()) {
            return redirect()
                ->route('materials.index')
                ->with('error', 'Tidak ada material yang dipilih.');
        }

        $count = $materials->count();

        foreach ($materials as $mat) {
            // Catat riwayat aktivitas stok
            StockMovement::create([
                'material_id'     => $mat->id,
                'user_id'         => Auth::id(),
                'activity'        => 'Hapus',
                'quantity_before' => (int) $mat->quantity,
                'quantity_after'  => 0,
                'quantity_change' => -((int) $mat->quantity),
                'description'     => 'Material dihapus dari sistem',
            ]);

            $mat->delete();
        }

        return redirect()
            ->route('materials.index')
            ->with('success', "{$count} material berhasil dihapus.");
    }

    /**
     * Export data material ke file Excel (.xlsx).
     */
    public function export(Request $request)
    {
        $search    = trim($request->input('search', ''));
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        $filename = 'Data_Material_ATK_PLN_' . date('Ymd_His') . '.xlsx';

        return Excel::download(
            new MaterialsExport(
                $search,
                $startDate,
                $endDate
            ),
            $filename
        );
    }

    public function downloadTemplate()
    {
        return Excel::download(
            new MaterialsTemplateExport(),
            'Template_Import_Material_ATK_PLN.xlsx'
        );
    }

    /**
 * Proses import data material dari Excel.
 */
    public function importForm()
    {
        return view('materials.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls',
                'max:5120',
            ],
        ], [
            'file.required' => 'File Excel wajib dipilih sebelum melakukan import.',
            'file.file'     => 'File yang dipilih tidak valid. Pastikan file tidak rusak.',
            'file.mimes'    => 'Format file tidak didukung. Gunakan file Excel dengan ekstensi .xlsx atau .xls.',
            'file.max'      => 'Ukuran file terlalu besar. Maksimal 5 MB.',
        ]);

        try {

            Excel::import(
                new MaterialsImport(),
                $request->file('file')
            );

            return redirect()
                ->route('materials.index')
                ->with(
                    'success',
                    'Data material berhasil diimport dari Excel.'
                );

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            // Ambil error validasi per baris dari Excel
            $failures = $e->failures();
            $errors   = [];

            foreach ($failures as $failure) {
                $baris = $failure->row();
                foreach ($failure->errors() as $pesan) {
                    $errors[] = "Baris {$baris}: {$pesan}";
                }
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('import_errors', $errors)
                ->with('error_type', 'validation');

        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'File Excel tidak dapat dibaca. Pastikan file tidak rusak dan formatnya sesuai.')
                ->with('error_type', 'file');

        } catch (\Exception $e) {

            // Terjemahkan pesan teknis ke bahasa yang mudah dipahami
            $message = $e->getMessage();
            $friendlyMessage = $this->translateImportError($message);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $friendlyMessage)
                ->with('error_type', 'general');
        }
    }

    /**
     * Terjemahkan pesan error teknis menjadi pesan yang ramah pengguna.
     */
    private function translateImportError(string $message): string
    {
        // Kolom tidak ditemukan / header salah
        if (
            str_contains($message, 'Undefined array key') ||
            str_contains($message, 'undefined index') ||
            str_contains($message, 'does not exist')
        ) {
            return 'Import gagal. Nama kolom di file Excel tidak sesuai. Pastikan kolom yang ada adalah: No Material, Nama Material, Tanggal Masuk, Jumlah Item, Satuan, Deskripsi. Gunakan template yang tersedia.';
        }

        // File kosong / tidak ada data
        if (
            str_contains($message, 'empty') ||
            str_contains($message, 'no rows')
        ) {
            return 'Import gagal. File Excel yang diunggah tidak memiliki data. Pastikan file berisi minimal satu baris data.';
        }

        // Format tanggal salah
        if (
            str_contains($message, 'date') ||
            str_contains($message, 'DateTime') ||
            str_contains($message, 'createFromFormat')
        ) {
            return 'Import gagal. Format tanggal di kolom "Tanggal Masuk" tidak dikenali. Gunakan format DD/MM/YYYY (contoh: 01/07/2025).';
        }

        // No material duplikat
        if (
            str_contains($message, 'Duplicate entry') ||
            str_contains($message, 'SQLSTATE[23000]') ||
            str_contains($message, 'unique constraint') ||
            str_contains($message, 'Integrity constraint')
        ) {
            return 'Import gagal. Terdapat No Material di file yang sudah terdaftar di sistem. Periksa kembali kolom No Material dan pastikan setiap nomor unik.';
        }

        // File tidak bisa dibuka / korup
        if (
            str_contains($message, 'zip') ||
            str_contains($message, 'reader') ||
            str_contains($message, 'Invalid file') ||
            str_contains($message, 'not a valid')
        ) {
            return 'Import gagal. File Excel tidak dapat dibuka. Kemungkinan file rusak atau formatnya tidak didukung. Coba simpan ulang file Excel Anda dan upload kembali.';
        }

        // Fallback umum
        return 'Import gagal. Periksa kembali format file dan data yang diunggah. Pastikan semua kolom terisi dengan benar dan gunakan template yang tersedia.';
    }
}