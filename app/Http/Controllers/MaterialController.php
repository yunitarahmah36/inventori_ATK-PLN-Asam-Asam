<?php

namespace App\Http\Controllers;

use App\Exports\MaterialsExport;
use App\Exports\MaterialsTemplateExport;
use App\Imports\MaterialsImport;
use App\Models\Material;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MaterialController extends Controller
{
    /**
     * Tampilkan daftar master data material dengan pencarian dan pagination.
     * Hanya menampilkan identitas material (No. Material, Nama Material, Satuan, dan Aksi).
     */
    public function index(Request $request)
    {
        $search  = trim($request->input('search', ''));
        $status  = $request->input('status', 'all'); // 'all', 'active', 'inactive'
        $perPage = $request->input('per_page', 25);

        $query = Material::query();

        // Pencarian berdasarkan No Material atau Nama Material
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('material_number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Filter status aktif/nonaktif
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Urutkan berdasarkan No Material secara teratur
        $query->orderBy('material_number', 'asc')->orderBy('id', 'asc');

        // Hitung total data sesuai filter
        $totalFiltered = (clone $query)->count();

        // Pagination sesuai pilihan dropdown
        if ($perPage === 'all' || $perPage === 'Semua') {
            $perPageValue = $totalFiltered > 0 ? $totalFiltered : 25;
        } else {
            $perPageValue = in_array((int) $perPage, [10, 25, 50, 100, 250])
                ? (int) $perPage
                : 25;
        }

        $materials = $query->paginate($perPageValue)->withQueryString();

        return view('materials.index', compact(
            'materials',
            'search',
            'status',
            'perPage',
            'totalFiltered'
        ));
    }

    /**
     * Tampilkan form penambahan master material baru (No. Material, Nama Material, Satuan).
     */
    public function create()
    {
        // Generate saran No Material otomatis berikutnya
        $latestMaterial = Material::orderBy('id', 'desc')->first();
        $suggestedNumber = 'MAT001';

        if ($latestMaterial && preg_match('/^MAT(\d+)$/i', $latestMaterial->material_number, $matches)) {
            $nextNum = ((int) $matches[1]) + 1;
            $suggestedNumber = 'MAT' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
        }

        return view('materials.create', compact('suggestedNumber'));
    }

    /**
     * Simpan data master material baru.
     * Semua kolom (No. Material, Nama Material, Satuan) wajib diisi.
     * No. Material harus unik.
     * Penambahan data master tidak menambah atau mengubah kuantitas stok.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_number' => [
                'required',
                'string',
                'max:50',
                'unique:materials,material_number',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'unit' => [
                'required',
                'string',
                'max:50',
            ],
        ], [
            'material_number.required' => 'No. Material wajib diisi.',
            'material_number.unique'   => 'No. Material sudah terdaftar. Setiap material harus memiliki No. Material yang unik.',
            'material_number.max'      => 'No. Material maksimal 50 karakter.',
            'name.required'            => 'Nama Material wajib diisi.',
            'name.max'                 => 'Nama Material maksimal 255 karakter.',
            'unit.required'            => 'Satuan wajib diisi.',
            'unit.max'                 => 'Satuan maksimal 50 karakter.',
        ]);

        $materialNumber = trim($validated['material_number']);
        $materialName   = trim($validated['name']);
        $unit           = trim($validated['unit']);

        Material::create([
            'material_number' => $materialNumber,
            'name'            => $materialName,
            'unit'            => $unit,
            'entry_date'      => now()->toDateString(),
            'quantity'        => 0,
            'is_active'       => true,
            'created_by'      => Auth::id(),
        ]);

        return redirect()
            ->route('materials.index')
            ->with('success', "Material \"{$materialName}\" ({$materialNumber}) berhasil didaftarkan ke data master material.");
    }

    /**
     * Tampilkan form untuk mengedit master material (No. Material, Nama Material, Satuan).
     */
    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    /**
     * Perbarui data master material.
     * Validasi No. Material unik dengan mengecualikan material yang sedang diedit.
     * Tidak mengubah kuantitas stok. Sinkronkan snapshot riwayat jika No/Nama berubah.
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'material_number' => [
                'required',
                'string',
                'max:50',
                'unique:materials,material_number,' . $material->id,
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'unit' => [
                'required',
                'string',
                'max:50',
            ],
        ], [
            'material_number.required' => 'No. Material wajib diisi.',
            'material_number.unique'   => 'No. Material sudah digunakan untuk material lain. Setiap material harus memiliki No. Material yang unik.',
            'material_number.max'      => 'No. Material maksimal 50 karakter.',
            'name.required'            => 'Nama Material wajib diisi.',
            'name.max'                 => 'Nama Material maksimal 255 karakter.',
            'unit.required'            => 'Satuan wajib diisi.',
            'unit.max'                 => 'Satuan maksimal 50 karakter.',
        ]);

        $oldNumber = $material->material_number;
        $oldName   = $material->name;

        $newNumber = trim($validated['material_number']);
        $newName   = trim($validated['name']);
        $newUnit   = trim($validated['unit']);

        // Perbarui data master material tanpa mengubah kuantitas stok
        $material->update([
            'material_number' => $newNumber,
            'name'            => $newName,
            'unit'            => $newUnit,
        ]);

        // Jika No. Material atau Nama Material berubah, perbarui juga snapshot pada riwayat pergerakan stok
        // agar relasi dan histori tetap konsisten dan aman
        if ($oldNumber !== $newNumber || $oldName !== $newName) {
            StockMovement::where('material_id', $material->id)->update([
                'material_number' => $newNumber,
                'material_name'   => $newName,
            ]);
        }

        return redirect()
            ->route('materials.index')
            ->with('success', "Data master material \"{$newName}\" ({$newNumber}) berhasil diperbarui.");
    }

    /**
     * Hapus material:
     * - Jika material belum pernah digunakan dan tidak memiliki relasi: hapus permanen.
     * - Jika material sudah memiliki riwayat stok: cegah penghapusan permanen dan lakukan penonaktifan.
     */
    public function destroy(Material $material)
    {
        try {
            $hasRelations = $material->stockMovements()->exists();

            if ($hasRelations) {
                // Material sudah memiliki riwayat stok -> cegah hapus permanen, lakukan penonaktifan
                $material->update([
                    'is_active' => false,
                ]);

                return redirect()
                    ->route('materials.index')
                    ->with('success', "Material \"{$material->name}\" ({$material->material_number}) memiliki riwayat pergerakan stok, sehingga dinonaktifkan dari sistem untuk menjaga keutuhan riwayat data.");
            } else {
                // Belum pernah digunakan dan tidak memiliki relasi riwayat stok -> hapus permanen
                $name   = $material->name;
                $number = $material->material_number;
                $material->delete();

                return redirect()
                    ->route('materials.index')
                    ->with('success', "Material \"{$name}\" ({$number}) berhasil dihapus dari sistem.");
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('materials.index')
                ->with('error', "Gagal memproses penghapusan material: " . $e->getMessage());
        }
    }

    /**
     * Aktifkan kembali material yang sebelumnya dinonaktifkan.
     */
    public function reactivate(Material $material)
    {
        $material->update([
            'is_active' => true,
        ]);

        return redirect()
            ->route('materials.index')
            ->with('success', "Material \"{$material->name}\" ({$material->material_number}) berhasil diaktifkan kembali.");
    }

    /**
     * Hapus beberapa material sekaligus secara aman.
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

        $deletedCount     = 0;
        $deactivatedCount = 0;

        try {
            DB::transaction(function () use ($materials, &$deletedCount, &$deactivatedCount) {
                foreach ($materials as $mat) {
                    if ($mat->stockMovements()->exists()) {
                        $mat->update(['is_active' => false]);
                        $deactivatedCount++;
                    } else {
                        $mat->delete();
                        $deletedCount++;
                    }
                }
            });

            $msgParts = [];
            if ($deletedCount > 0) {
                $msgParts[] = "{$deletedCount} material berhasil dihapus permanen";
            }
            if ($deactivatedCount > 0) {
                $msgParts[] = "{$deactivatedCount} material dinonaktifkan (memiliki riwayat stok)";
            }

            $message = implode(', ', $msgParts) . '.';

            return redirect()
                ->route('materials.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()
                ->route('materials.index')
                ->with('error', "Gagal memproses penghapusan material terpilih: " . $e->getMessage());
        }
    }

    /**
     * Export master data material ke file Excel (.xlsx) dengan hanya 4 kolom (No, No. Material, Nama Material, Satuan).
     */
    public function export(Request $request)
    {
        $search = trim($request->input('search', ''));
        $filename = 'Data_Master_Material_ATK_PLN_' . date('Ymd_His') . '.xlsx';

        return Excel::download(
            new MaterialsExport($search),
            $filename
        );
    }

    /**
     * Download template Excel format baru (hanya 3 kolom: No. Material, Nama Material, Satuan).
     */
    public function downloadTemplate()
    {
        return Excel::download(
            new MaterialsTemplateExport(),
            'Template_Master_Material_ATK_PLN.xlsx'
        );
    }

    /**
     * Tampilkan halaman import Excel.
     */
    public function importForm()
    {
        $preview = session('import_preview');
        return view('materials.import', compact('preview'));
    }

    /**
     * Analisis dan pratinjau data file Excel sebelum konfirmasi import:
     * - Menghitung data baru, duplikat, dan konflik.
     * - Menyimpan hasil pratinjau ke sesi untuk konfirmasi pengguna.
     */
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
            $file = $request->file('file');
            $preview = MaterialsImport::parseFile($file);

            // Jika langsung meminta konfirmasi atau dipanggil secara terprogram
            if ($request->boolean('confirm_now')) {
                return $this->processConfirmedImport($preview['new_items']);
            }

            // Simpan data pratinjau ke dalam sesi pengguna
            session(['import_preview' => $preview]);

            return redirect()
                ->route('materials.import.form')
                ->with('info_preview', true);
        } catch (\Exception $e) {
            return redirect()
                ->route('materials.import.form')
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Konfirmasi import: Simpan data baru yang valid ke dalam database.
     * Tidak mengubah kuantitas stok atau membuat catatan riwayat stok.
     */
    public function confirmImport(Request $request)
    {
        $preview = session('import_preview');

        if (empty($preview) || empty($preview['new_items'])) {
            return redirect()
                ->route('materials.import.form')
                ->with('error', 'Tidak ada data material baru yang siap diimpor. Seluruh data sudah terdaftar atau file belum diunggah.');
        }

        return $this->processConfirmedImport($preview['new_items']);
    }

    /**
     * Batalkan pratinjau import dan bersihkan sesi.
     */
    public function cancelImport()
    {
        session()->forget('import_preview');

        return redirect()
            ->route('materials.import.form')
            ->with('info', 'Pratinjau import dibatalkan. Anda dapat mengunggah file baru.');
    }

    /**
     * Proses penyimpanan baris material baru ke database.
     */
    protected function processConfirmedImport(array $newItems)
    {
        if (empty($newItems)) {
            session()->forget('import_preview');
            return redirect()
                ->route('materials.index')
                ->with('info', 'Tidak ada data material baru yang ditambahkan karena seluruh data sudah terdaftar.');
        }

        $now = now();
        $userId = Auth::id();
        $toInsert = [];

        foreach ($newItems as $item) {
            $toInsert[] = [
                'material_number' => trim($item['material_number']),
                'name'            => trim($item['name']),
                'unit'            => trim($item['unit']),
                'entry_date'      => $now->toDateString(),
                'quantity'        => 0,
                'is_active'       => true,
                'created_by'      => $userId,
                'created_at'      => $now,
                'updated_at'      => $now,
            ];
        }

        DB::transaction(function () use ($toInsert) {
            Material::insert($toInsert);
        });

        session()->forget('import_preview');

        $count = count($toInsert);

        return redirect()
            ->route('materials.index')
            ->with('success', "Berhasil mengimpor {$count} data master material baru ke sistem tanpa mengubah stok.");
    }

    /**
     * Handler pencatatan stok keluar langsung jika dipanggil dari modal cepat (kompatibilitas).
     */
    public function stockOut(Request $request, Material $material)
    {
        if (!$material->is_active) {
            return redirect()
                ->route('materials.index')
                ->with('error', "Material \"{$material->name}\" telah dinonaktifkan dan tidak dapat digunakan untuk transaksi stok keluar.");
        }

        $validated = $request->validate([
            'quantity'    => 'required|integer|min:1',
            'exit_date'   => 'required|date',
            'recipient'   => 'nullable|string|max:255',
            'description' => 'required|string|max:1000',
        ], [
            'quantity.required'    => 'Jumlah keluar wajib diisi.',
            'quantity.integer'     => 'Jumlah keluar harus berupa angka bulat.',
            'quantity.min'         => 'Jumlah keluar wajib lebih dari 0.',
            'exit_date.required'   => 'Tanggal keluar wajib diisi.',
            'exit_date.date'       => 'Format tanggal keluar tidak valid.',
            'recipient.max'        => 'Penerima maksimal 255 karakter.',
            'description.required' => 'Keterangan/tujuan pengeluaran wajib diisi.',
            'description.max'      => 'Keterangan/tujuan pengeluaran maksimal 1000 karakter.',
        ]);

        $qtyOut = (int) $validated['quantity'];

        try {
            DB::transaction(function () use ($material, $validated, $qtyOut) {
                $lockedMaterial = Material::lockForUpdate()->findOrFail($material->id);

                if (!$lockedMaterial->is_active) {
                    throw new \Exception("Material ini telah dinonaktifkan.");
                }

                $currentQty = (int) $lockedMaterial->quantity;

                if ($qtyOut > $currentQty) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'quantity' => "Jumlah keluar ({$qtyOut} {$lockedMaterial->unit}) melebihi stok yang tersedia ({$currentQty} {$lockedMaterial->unit}).",
                    ]);
                }

                $newQty = $currentQty - $qtyOut;

                $lockedMaterial->update([
                    'quantity' => $newQty,
                ]);

                $exitDateTime = \Carbon\Carbon::parse($validated['exit_date'])->setTime(
                    now()->hour,
                    now()->minute,
                    now()->second
                );

                StockMovement::create([
                    'material_id'     => $lockedMaterial->id,
                    'material_name'   => $lockedMaterial->name,
                    'material_number' => $lockedMaterial->material_number,
                    'user_id'         => Auth::id() ?? 1,
                    'activity'        => 'Keluar',
                    'quantity_before' => $currentQty,
                    'quantity_after'  => $newQty,
                    'quantity_change' => -$qtyOut,
                    'recipient'       => !empty($validated['recipient']) ? trim($validated['recipient']) : null,
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
     * Normalisasi nama material.
     */
    public static function normalizeName(?string $name): string
    {
        return MaterialsImport::normalizeName($name);
    }
}