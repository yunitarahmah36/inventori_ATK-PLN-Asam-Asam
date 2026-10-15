<?php

namespace App\Http\Controllers;

use App\Mail\PengambilanBarangReceiptMail;
use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class LandingController extends Controller
{
    /**
     * Tampilkan landing page publik inventori material.
     */
    public function index(Request $request)
    {
        if ($request->has('baru') || $request->has('new')) {
            session()->forget(['success_pengambilan', 'receipt_data']);
        }

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
        session()->forget(['success_pengambilan', 'receipt_data']);
        return redirect()->to(route('landing') . '#form-pengambilan');
    }

    /**
     * Simpan transaksi pencatatan pengambilan barang dari halaman publik tanpa login.
     * Mengurangi stok secara otomatis dan mencatat ke riwayat pergerakan stok.
     */
    public function storePengambilan(Request $request)
    {
        // Normalisasi input jika dikirim format single (backward compatibility untuk test atau form lama)
        if (!$request->has('items') && $request->filled('material_id')) {
            $request->merge([
                'items' => [
                    [
                        'material_id' => $request->input('material_id'),
                        'quantity'    => $request->input('quantity'),
                    ]
                ]
            ]);
        }

        $validated = $request->validate([
            'nama_pengambil'      => 'required|string|max:255',
            'divisi'              => 'required|string|max:255',
            'items'               => 'required|array|min:1',
            'items.*.material_id' => 'required|exists:materials,id',
            'items.*.quantity'    => 'required|integer|min:1',
            'description'         => 'nullable|string|max:1000',
        ], [
            'nama_pengambil.required'      => 'Nama pengambil wajib diisi.',
            'divisi.required'              => 'Bagian / Divisi wajib diisi.',
            'items.required'               => 'Silakan pilih minimal satu barang yang diambil.',
            'items.min'                    => 'Silakan pilih minimal satu barang yang diambil.',
            'items.*.material_id.required' => 'Silakan pilih barang yang diambil.',
            'items.*.material_id.exists'   => 'Barang yang dipilih tidak ditemukan dalam sistem.',
            'items.*.quantity.required'    => 'Jumlah barang wajib diisi.',
            'items.*.quantity.integer'     => 'Jumlah barang harus berupa angka bulat positif.',
            'items.*.quantity.min'         => 'Jumlah barang minimal 1 unit.',
            'description.max'              => 'Keterangan maksimal 1000 karakter.',
        ]);

        try {
            $result = DB::transaction(function () use ($validated) {
                $userId = Auth::id() ?? (User::first()->id ?? 1);
                $recipientFormatted = trim($validated['nama_pengambil']) . ' (' . trim($validated['divisi']) . ')';
                $descNote = !empty($validated['description'])
                    ? 'Pengambilan Mandiri: ' . trim($validated['description'])
                    : 'Pengambilan Mandiri via Portal Publik';

                $processedItems = [];

                foreach ($validated['items'] as $index => $item) {
                    $matId  = $item['material_id'];
                    $qtyOut = (int) $item['quantity'];

                    // Lock row material untuk keamanan dari race condition
                    $material = Material::lockForUpdate()->findOrFail($matId);
                    $currentQty = (int) $material->quantity;

                    // Validasi ketersediaan stok
                    if ($qtyOut > $currentQty) {
                        $errorMsg = "Stok tidak mencukupi untuk \"{$material->name}\"! Jumlah yang diambil ({$qtyOut} {$material->unit}) melebihi stok yang tersedia ({$currentQty} {$material->unit}).";
                        throw ValidationException::withMessages([
                            'quantity'                 => $errorMsg,
                            "items.{$index}.quantity" => $errorMsg,
                        ]);
                    }

                    $newQty = $currentQty - $qtyOut;

                    // Kurangi stok barang secara otomatis
                    $material->update([
                        'quantity' => $newQty,
                    ]);

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

                    $processedItems[] = [
                        'material_name'   => $material->name,
                        'material_number' => $material->material_number,
                        'unit'            => $material->unit,
                        'qty_out'         => $qtyOut,
                        'remaining_stock' => $newQty,
                    ];
                }

                $firstItem = $processedItems[0];

                return [
                    // Field backward compatibility
                    'material_name'   => count($processedItems) === 1 ? $firstItem['material_name'] : (count($processedItems) . ' jenis material'),
                    'material_number' => count($processedItems) === 1 ? $firstItem['material_number'] : '-',
                    'unit'            => count($processedItems) === 1 ? $firstItem['unit'] : 'Item',
                    'qty_out'         => count($processedItems) === 1 ? $firstItem['qty_out'] : array_sum(array_column($processedItems, 'qty_out')),
                    'remaining_stock' => count($processedItems) === 1 ? $firstItem['remaining_stock'] : '-',
                    'nama_pengambil'  => trim($validated['nama_pengambil']),
                    'divisi'          => trim($validated['divisi']),
                    'recipient'       => $recipientFormatted,
                    'description'     => trim($validated['description'] ?? ''),
                    'date'            => now()->translatedFormat('d F Y, H:i') . ' WITA',
                    'items'           => $processedItems,
                ];
            });

            // =========================================================================
            // PENGIRIMAN OTOMATIS BUKTI RESI MELALUI EMAIL KE 3 ALAMAT ADMIN:
            // 1. Admin Keuangan : finance.inventori@gmail.com
            // 2. Admin Inventori: admin.inventoripln@gmail.com
            // 3. General        : general.inventoripln@gmail.com
            // Dilakukan setelah database commit & stok berhasil diperbarui.
            // =========================================================================
            $recipients = config('mail.recipients_pengambilan');
            if (empty($recipients)) {
                $recipients = [
                    'finance.inventori@gmail.com',
                    'admin.inventoripln@gmail.com',
                    'general.inventoripln@gmail.com',
                ];
            }

            $emailErrors = [];
            $sentRecipients = [];

            foreach ($recipients as $recipientEmail) {
                try {
                    Mail::to($recipientEmail)->send(new PengambilanBarangReceiptMail($result));
                    $sentRecipients[] = $recipientEmail;
                } catch (\Throwable $mailEx) {
                    Log::error("Gagal mengirim email resi pengambilan barang ke [{$recipientEmail}]: " . $mailEx->getMessage(), [
                        'recipient' => $recipientEmail,
                        'receipt'   => $result,
                        'exception' => $mailEx,
                    ]);
                    $emailErrors[] = $recipientEmail;
                }
            }

            $itemsCount = count($result['items']);
            $successMsg = $itemsCount === 1
                ? "Pengambilan barang \"{$result['items'][0]['material_name']}\" sebanyak {$result['items'][0]['qty_out']} {$result['items'][0]['unit']} berhasil disimpan!"
                : "Pengambilan {$itemsCount} jenis barang berhasil disimpan!";

            $redirect = redirect()
                ->to(route('landing') . '#form-pengambilan')
                ->with('success_pengambilan', $successMsg)
                ->with('receipt_data', $result);

            if (!empty($emailErrors)) {
                $redirect->with('email_warning', 'Pengambilan barang berhasil dicatat & stok telah diperbarui. Namun terjadi kendala pada pengiriman email ke: ' . implode(', ', $emailErrors) . '. Detail error telah dicatat ke log sistem.');
            } else {
                $redirect->with('email_sent', 'Bukti resi telah dikirimkan secara otomatis ke alamat email: ' . implode(', ', $sentRecipients) . '.');
            }

            return $redirect;

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
