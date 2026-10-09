<?php

namespace App\Http\Controllers;

use App\Exports\MaterialsExport;
use App\Models\Material;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $search      = trim($request->input('search', ''));
        $startDate   = $request->input('start_date');
        $endDate     = $request->input('end_date');
        $perPage     = $request->input('per_page', 25);
        $filterStock = $request->input('filter_stock');

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

        // Filter stok menipis (<= 15 unit)
        if ($filterStock === 'low') {
            $query->where('quantity', '<=', 15);
            $query->orderBy('quantity', 'asc')->orderBy('entry_date', 'asc');
        } else {
            // Urutkan dari yang terbaru
            $query->latest('entry_date')->latest('id');
        }

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
            'filterStock',
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
     * Normalisasi nama material dengan mengabaikan huruf besar/kecil dan spasi berlebih.
     */
    public static function normalizeName(?string $name): string
    {
        if ($name === null) {
            return '';
        }
        $cleaned = preg_replace('/\s+/u', ' ', trim($name));
        return mb_strtolower($cleaned, 'UTF-8');
    }

    /**
     * Simpan material baru ke database dan catat riwayat stok.
     * Jika No Material dan nama material sama (setelah normalisasi), jangan ditolak sebagai duplikat;
     * cukup cegah pembuatan data ganda dengan menambahkan stok ke material yang sudah ada.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_number' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($request) {
                    $matNumber = trim((string) $value);
                    $existing = Material::whereRaw('LOWER(TRIM(material_number)) = ?', [strtolower($matNumber)])->first();
                    if ($existing) {
                        $inputName = (string) $request->input('name');
                        $normalizedInputName = self::normalizeName($inputName);
                        $normalizedExistingName = self::normalizeName($existing->name);

                        if ($normalizedInputName === '' || $normalizedInputName !== $normalizedExistingName) {
                            $fail("No Material '{$matNumber}' sudah digunakan untuk material '{$existing->name}'. No Material yang sama tidak boleh digunakan untuk nama material yang berbeda.");
                        }
                    }
                },
            ],
            'name'            => 'required|string|max:255',
            'entry_date'      => 'required|date',
            'quantity'        => 'required|integer|min:0',
            'unit'            => 'required|string|max:50',
            'description'     => 'nullable|string|max:1000',
        ], [
            'material_number.required' => 'No Material wajib diisi.',
            'name.required'            => 'Nama Material wajib diisi.',
            'entry_date.required'      => 'Tanggal Masuk wajib diisi.',
            'entry_date.date'          => 'Format tanggal tidak valid.',
            'quantity.required'        => 'Jumlah Item wajib diisi.',
            'quantity.integer'         => 'Jumlah Item harus berupa angka.',
            'quantity.min'             => 'Jumlah Item tidak boleh bernilai negatif.',
            'unit.required'            => 'Satuan wajib diisi.',
        ]);

        $matNumber = trim($validated['material_number']);
        $inputName = trim($validated['name']);
        $normalizedInputName = self::normalizeName($inputName);

        // Cari apakah No Material sudah ada di database
        $existing = Material::whereRaw('LOWER(TRIM(material_number)) = ?', [strtolower($matNumber)])->first();

        if ($existing) {
            // No Material dan nama material sama setelah normalisasi:
            // Cegah pembuatan data ganda dengan menambahkan stok ke data yang sudah ada
            $qtyBefore = (int) $existing->quantity;
            $addQty    = (int) $validated['quantity'];
            $qtyAfter  = $qtyBefore + $addQty;

            $existing->update([
                'quantity'    => $qtyAfter,
                'entry_date'  => $validated['entry_date'] > $existing->entry_date ? $validated['entry_date'] : $existing->entry_date,
                'description' => $validated['description'] ?: $existing->description,
            ]);

            StockMovement::create([
                'material_id'     => $existing->id,
                'material_name'   => $existing->name,
                'material_number' => $existing->material_number,
                'user_id'         => Auth::id(),
                'activity'        => 'Tambah',
                'quantity_before' => $qtyBefore,
                'quantity_after'  => $qtyAfter,
                'quantity_change' => $addQty,
                'description'     => $validated['description']
                    ?: 'Penambahan stok material',
            ]);

            return redirect()
                ->route('materials.index')
                ->with('success', 'Stok material berhasil ditambahkan ke data material yang sudah ada.');
        }

        // Jika material belum ada, buat record material baru
        $material = Material::create([
            'material_number' => $matNumber,
            'name'            => $inputName,
            'entry_date'      => $validated['entry_date'],
            'quantity'        => (int) $validated['quantity'],
            'unit'            => $validated['unit'],
            'description'     => $validated['description'] ?? null,
            'created_by'      => Auth::id(),
        ]);

        // Catat riwayat aktivitas stok
        StockMovement::create([
            'material_id'     => $material->id,
            'material_name'   => $material->name,
            'material_number' => $material->material_number,
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
            'material_number' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($request, $material) {
                    $matNumber = trim((string) $value);
                    $other = Material::where('id', '!=', $material->id)
                        ->whereRaw('LOWER(TRIM(material_number)) = ?', [strtolower($matNumber)])
                        ->first();
                    if ($other) {
                        $inputName = (string) $request->input('name');
                        $normalizedInputName = self::normalizeName($inputName);
                        $normalizedOtherName = self::normalizeName($other->name);

                        if ($normalizedInputName !== $normalizedOtherName) {
                            $fail("No Material '{$matNumber}' sudah digunakan untuk material '{$other->name}'. No Material yang sama tidak boleh digunakan untuk nama material yang berbeda.");
                        } else {
                            $fail("No Material '{$matNumber}' sudah terdaftar pada entri material lain.");
                        }
                    }
                },
            ],
            'name'        => 'required|string|max:255',
            'entry_date'  => 'required|date',
            'quantity'    => 'nullable',
            'unit'        => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
        ], [
            'material_number.required' => 'No Material wajib diisi.',
            'name.required'            => 'Nama Material wajib diisi.',
            'entry_date.required'      => 'Tanggal Masuk wajib diisi.',
            'entry_date.date'          => 'Format tanggal tidak valid.',
            'unit.required'            => 'Satuan wajib diisi.',
        ]);

        $currentQty = (int) $material->quantity;

        // Update informasi material tanpa mengubah kuantitas stok
        $material->update([
            'material_number' => $validated['material_number'],
            'name'            => $validated['name'],
            'entry_date'      => $validated['entry_date'],
            'unit'            => $validated['unit'],
            'description'     => $validated['description'] ?? null,
        ]);

        // Catat riwayat aktivitas stok (perubahan stok = 0)
        StockMovement::create([
            'material_id'     => $material->id,
            'material_name'   => $material->name,
            'material_number' => $material->material_number,
            'user_id'         => Auth::id(),
            'activity'        => 'Edit',
            'quantity_before' => $currentQty,
            'quantity_after'  => $currentQty,
            'quantity_change' => 0,
            'description'     => 'Pembaruan informasi data material',
        ]);

        return redirect()
            ->route('materials.index')
            ->with('success', 'Material berhasil diperbarui.');
    }

    /**
     * Catat pengeluaran stok material (Stok Keluar), kurangi jumlah stok,
     * dan catat riwayat pergerakan stok menggunakan database transaction.
     */
    public function stockOut(Request $request, Material $material)
    {
        $validated = $request->validate([
            'quantity'    => 'required|integer|min:1',
            'exit_date'   => 'required|date',
            'description' => 'required|string|max:1000',
        ], [
            'quantity.required'    => 'Jumlah keluar wajib diisi.',
            'quantity.integer'     => 'Jumlah keluar harus berupa angka bulat.',
            'quantity.min'         => 'Jumlah keluar wajib lebih dari 0.',
            'exit_date.required'   => 'Tanggal keluar wajib diisi.',
            'exit_date.date'       => 'Format tanggal keluar tidak valid.',
            'description.required' => 'Keterangan/tujuan pengeluaran wajib diisi.',
            'description.max'      => 'Keterangan/tujuan pengeluaran maksimal 1000 karakter.',
        ]);

        $qtyOut = (int) $validated['quantity'];

        try {
            DB::transaction(function () use ($material, $validated, $qtyOut) {
                // Lock data material untuk mencegah race condition
                $lockedMaterial = Material::lockForUpdate()->findOrFail($material->id);

                $currentQty = (int) $lockedMaterial->quantity;

                // Validasi agar jumlah keluar tidak melebihi stok yang tersedia
                if ($qtyOut > $currentQty) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'quantity' => "Jumlah keluar ({$qtyOut} {$lockedMaterial->unit}) melebihi stok yang tersedia ({$currentQty} {$lockedMaterial->unit}).",
                    ]);
                }

                $newQty = $currentQty - $qtyOut;

                // Update stok material
                $lockedMaterial->update([
                    'quantity' => $newQty,
                ]);

                // Tanggal dan waktu pergerakan stok keluar
                $exitDateTime = \Carbon\Carbon::parse($validated['exit_date'])->setTime(
                    now()->hour,
                    now()->minute,
                    now()->second
                );

                // Catat ke Riwayat Pergerakan Material
                StockMovement::create([
                    'material_id'     => $lockedMaterial->id,
                    'material_name'   => $lockedMaterial->name,
                    'material_number' => $lockedMaterial->material_number,
                    'user_id'         => Auth::id(),
                    'activity'        => 'Keluar',
                    'quantity_before' => $currentQty,
                    'quantity_after'  => $newQty,
                    'quantity_change' => -$qtyOut,
                    'description'     => trim($validated['description']),
                    'created_at'      => $exitDateTime,
                ]);
            });

            return redirect()
                ->route('materials.index')
                ->with('success', "Stok keluar material \"{$material->name}\" sebanyak {$qtyOut} {$material->unit} berhasil dicatat.");
        } catch (\Illuminate\Validation\ValidationException $ve) {
            throw $ve;
        } catch (\Exception $e) {
            return redirect()
                ->route('materials.index')
                ->with('error', "Gagal memproses stok keluar: " . $e->getMessage());
        }
    }

    /**
     * Hapus data material dari tabel materials, namun tetap mempertahankan riwayat stok.
     */
    public function destroy(Material $material)
    {
        try {
            $materialName   = $material->name;
            $materialNumber = $material->material_number;

            DB::transaction(function () use ($material, $materialName, $materialNumber) {
                // Pastikan riwayat stok sebelumnya memiliki snapshot nama dan no material
                $material->stockMovements()->update([
                    'material_name'   => $materialName,
                    'material_number' => $materialNumber,
                ]);

                // Catat riwayat aktivitas stok untuk aksi hapus
                StockMovement::create([
                    'material_id'     => $material->id,
                    'material_name'   => $materialName,
                    'material_number' => $materialNumber,
                    'user_id'         => Auth::id(),
                    'activity'        => 'Hapus',
                    'quantity_before' => (int) $material->quantity,
                    'quantity_after'  => 0,
                    'quantity_change' => -((int) $material->quantity),
                    'description'     => 'Material dihapus dari sistem',
                ]);

                // Hapus data material dari tabel materials (stock_movements akan diset material_id = null oleh FK)
                $material->delete();
            });

            return redirect()
                ->route('materials.index')
                ->with('success', "Material \"{$materialName}\" berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()
                ->route('materials.index')
                ->with('error', "Gagal menghapus material: " . $e->getMessage());
        }
    }

    /**
     * Hapus beberapa material sekaligus dari tabel materials, namun tetap mempertahankan riwayat stok.
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

        try {
            DB::transaction(function () use ($materials) {
                foreach ($materials as $mat) {
                    $mat->stockMovements()->update([
                        'material_name'   => $mat->name,
                        'material_number' => $mat->material_number,
                    ]);

                    StockMovement::create([
                        'material_id'     => $mat->id,
                        'material_name'   => $mat->name,
                        'material_number' => $mat->material_number,
                        'user_id'         => Auth::id(),
                        'activity'        => 'Hapus',
                        'quantity_before' => (int) $mat->quantity,
                        'quantity_after'  => 0,
                        'quantity_change' => -((int) $mat->quantity),
                        'description'     => 'Material dihapus dari sistem',
                    ]);

                    $mat->delete();
                }
            });

            return redirect()
                ->route('materials.index')
                ->with('success', "{$count} material berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()
                ->route('materials.index')
                ->with('error', "Gagal menghapus material: " . $e->getMessage());
        }
    }

    /**
     * Export data material ke file Excel (.xlsx).
     */
    public function export(Request $request)
    {
        $search      = trim($request->input('search', ''));
        $startDate   = $request->input('start_date');
        $endDate     = $request->input('end_date');
        $perPage     = $request->input('per_page', 25);
        $page        = $request->input('page', 1);
        $filterStock = $request->input('filter_stock');

        $filename = 'Data_Material_ATK_PLN_' . date('Ymd_His') . '.xlsx';

        return Excel::download(
            new MaterialsExport(
                $search,
                $startDate,
                $endDate,
                $perPage,
                $page,
                $filterStock
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

        } catch (\Illuminate\Validation\ValidationException $e) {

            $errors = [];
            foreach ($e->errors() as $field => $messages) {
                foreach ($messages as $pesan) {
                    $errors[] = $pesan;
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