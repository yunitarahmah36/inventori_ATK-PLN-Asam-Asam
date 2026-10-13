<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LandingController extends Controller
{
    /**
     * Tampilkan landing page publik inventori material.
     */
    public function index()
    {
        // Ambil data material yang memiliki stok untuk pilihan form pengambilan
        $materials = Material::where('quantity', '>', 0)
            ->orderBy('name', 'asc')
            ->get(['id', 'material_number', 'name', 'quantity', 'unit']);

        // Statistik ringkas untuk ditampilkan di landing page
        $totalItemsAvailable = Material::where('quantity', '>', 0)->count();
        $totalQuantityInStock = (int) Material::sum('quantity');
        $totalTransactions = StockMovement::count();
        $recentTransactions = StockMovement::with('material')
            ->where('activity', 'Keluar')
            ->latest()
            ->take(5)
            ->get();

        return view('landing', compact(
            'materials',
            'totalItemsAvailable',
            'totalQuantityInStock',
            'totalTransactions',
            'recentTransactions'
        ));
    }

    /**
     * Form langsung pengambilan barang publik (redirect or anchor).
     */
    public function pengambilanForm()
    {
        return redirect()->to(route('landing') . '#form-pengambilan');
    }

    /**
     * Simpan transaksi pencatatan pengambilan barang dari halaman publik tanpa login.
     * Mengurangi stok secara otomatis dan mencatat ke riwayat pergerakan stok.
     */
    public function storePengambilan(Request $request)
    {
        $validated = $request->validate([
            'nama_pengambil' => 'required|string|max:255',
            'divisi'         => 'required|string|max:255',
            'material_id'    => 'required|exists:materials,id',
            'quantity'       => 'required|integer|min:1',
            'description'    => 'nullable|string|max:1000',
        ], [
            'nama_pengambil.required' => 'Nama pengambil wajib diisi.',
            'divisi.required'         => 'Bagian / Divisi wajib diisi.',
            'material_id.required'    => 'Silakan pilih barang yang diambil.',
            'material_id.exists'      => 'Barang yang dipilih tidak ditemukan dalam sistem.',
            'quantity.required'       => 'Jumlah barang wajib diisi.',
            'quantity.integer'        => 'Jumlah barang harus berupa angka bulat positif.',
            'quantity.min'            => 'Jumlah barang minimal 1 unit.',
            'description.max'         => 'Keterangan maksimal 1000 karakter.',
        ]);

        $qtyOut = (int) $validated['quantity'];

        try {
            $result = DB::transaction(function () use ($validated, $qtyOut) {
                // Lock row material untuk keamanan dari race condition
                $material = Material::lockForUpdate()->findOrFail($validated['material_id']);
                $currentQty = (int) $material->quantity;

                // Validasi ketersediaan stok
                if ($qtyOut > $currentQty) {
                    throw ValidationException::withMessages([
                        'quantity' => "Stok tidak mencukupi! Jumlah yang diambil ({$qtyOut} {$material->unit}) melebihi stok yang tersedia saat ini ({$currentQty} {$material->unit}).",
                    ]);
                }

                $newQty = $currentQty - $qtyOut;

                // Kurangi stok barang secara otomatis
                $material->update([
                    'quantity' => $newQty,
                ]);

                // Default user fallback jika guest
                $userId = Auth::id() ?? (User::first()->id ?? 1);

                $recipientFormatted = trim($validated['nama_pengambil']) . ' (' . trim($validated['divisi']) . ')';
                $descNote = !empty($validated['description'])
                    ? 'Pengambilan Mandiri: ' . trim($validated['description'])
                    : 'Pengambilan Mandiri via Portal Publik';

                // Catat transaksi ke riwayat pergerakan stok
                $movement = new StockMovement([
                    'material_id'     => $material->id,
                    'material_name'   => $material->name,
                    'material_number' => $material->material_number,
                    'user_id'         => $userId,
                    'activity'        => 'Keluar',
                    'quantity_before' => $currentQty,
                    'quantity_after'  => $newQty,
                    'quantity_change' => -$qtyOut,
                    'recipient'       => $recipientFormatted,
                    'description'     => $descNote,
                ]);
                $movement->created_at = now();
                $movement->save();

                return [
                    'material_name'   => $material->name,
                    'material_number' => $material->material_number,
                    'unit'            => $material->unit,
                    'qty_out'         => $qtyOut,
                    'remaining_stock' => $newQty,
                    'recipient'       => $recipientFormatted,
                    'date'            => now()->translatedFormat('d F Y, H:i') . ' WITA',
                ];
            });

            return redirect()
                ->to(route('landing') . '#form-pengambilan')
                ->with('success_pengambilan', "Pengambilan barang \"{$result['material_name']}\" sebanyak {$result['qty_out']} {$result['unit']} berhasil disimpan!")
                ->with('receipt_data', $result);

        } catch (ValidationException $ve) {
            throw $ve;
        } catch (\Exception $e) {
            return redirect()
                ->to(route('landing') . '#form-pengambilan')
                ->withInput()
                ->with('error_pengambilan', 'Gagal memproses pengambilan barang: ' . $e->getMessage());
        }
    }
}
