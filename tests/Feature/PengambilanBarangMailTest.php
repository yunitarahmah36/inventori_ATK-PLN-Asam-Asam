<?php

namespace Tests\Feature;

use App\Mail\PengambilanBarangReceiptMail;
use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PengambilanBarangMailTest extends TestCase
{
    use RefreshDatabase;

    private function createTestUser(): User
    {
        return User::create([
            'name'     => 'Petugas Gudang',
            'username' => 'petugas_' . uniqid(),
            'email'    => 'petugas_' . uniqid() . '@pln.com',
            'password' => Hash::make('password123'),
            'role'     => 'Admin',
        ]);
    }

    public function test_automatic_receipt_email_sent_to_three_specified_recipients(): void
    {
        Mail::fake();
        $this->createTestUser();

        $material = Material::create([
            'material_number' => 'ATK-KBL-001',
            'name'            => 'Kabel NYM 3x2.5mm',
            'quantity'        => 50,
            'unit'            => 'Meter',
            'description'     => 'Kabel instalasi',
        ]);

        $payload = [
            'nama_pengambil' => 'Ahmad Fauzi',
            'divisi'         => 'Pemeliharaan Listrik',
            'material_id'    => $material->id,
            'quantity'       => 10,
            'description'    => 'Penggantian kabel kontrol',
        ];

        $response = $this->post('/pengambilan-barang', $payload);

        $response->assertRedirect(route('landing') . '#form-pengambilan');
        $response->assertSessionHas('success_pengambilan');
        $response->assertSessionHas('receipt_data');
        $response->assertSessionHas('email_sent');

        // Pastikan stok berkurang
        $material->refresh();
        $this->assertEquals(40, $material->quantity);

        // Pastikan email terkirim ke ketiga alamat tepat 1 kali masing-masing
        $expectedRecipients = [
            'finance.inventori@gmail.com',
            'admin.inventoripln@gmail.com',
            'general.inventoripln@gmail.com',
        ];

        foreach ($expectedRecipients as $recipient) {
            Mail::assertSent(PengambilanBarangReceiptMail::class, function ($mail) use ($recipient) {
                return $mail->hasTo($recipient);
            });
        }

        Mail::assertSent(PengambilanBarangReceiptMail::class, 3);
    }

    public function test_receipt_email_content_contains_all_required_information(): void
    {
        Mail::fake();
        $this->createTestUser();

        $material = Material::create([
            'material_number' => 'ATK-KRT-099',
            'name'            => 'Kertas HVS A4 80gr',
            'quantity'        => 30,
            'unit'            => 'Rim',
        ]);

        $payload = [
            'nama_pengambil' => 'Rina Wijaya',
            'divisi'         => 'Keuangan & SDM',
            'material_id'    => $material->id,
            'quantity'       => 5,
            'description'    => 'Laporan bulanan',
        ];

        $this->post('/pengambilan-barang', $payload);

        Mail::assertSent(PengambilanBarangReceiptMail::class, function ($mail) {
            // Verifikasi subjek email
            $mailSubject = $mail->envelope()->subject;
            $this->assertStringContainsString('Rina Wijaya', $mailSubject);
            $this->assertStringContainsString('Keuangan & SDM', $mailSubject);

            // Render view email HTML dan verifikasi data
            $mailableHtml = $mail->render();
            $this->assertStringContainsString('ATK-KRT-099', $mailableHtml);
            $this->assertStringContainsString('Kertas HVS A4 80gr', $mailableHtml);
            $this->assertStringContainsString('5 Rim', $mailableHtml);
            $this->assertStringContainsString('25 Rim', $mailableHtml); // Sisa stok
            $this->assertStringContainsString('Rina Wijaya', $mailableHtml);
            $this->assertStringContainsString(e('Keuangan & SDM'), $mailableHtml);
            $this->assertStringContainsString('BUKTI RESI PENGAMBILAN BARANG', $mailableHtml);

            return true;
        });
    }

    public function test_multiple_materials_included_in_single_receipt_and_sent_once_per_recipient(): void
    {
        Mail::fake();
        $this->createTestUser();

        $matA = Material::create([
            'material_number' => 'MAT-A-01',
            'name'            => 'Spidol Boardmarker Hitam',
            'quantity'        => 20,
            'unit'            => 'Pcs',
        ]);

        $matB = Material::create([
            'material_number' => 'MAT-B-02',
            'name'            => 'Penghapus Whiteboard',
            'quantity'        => 15,
            'unit'            => 'Pcs',
        ]);

        $payload = [
            'nama_pengambil' => 'Budi Santoso',
            'divisi'         => 'Operasi',
            'items'          => [
                ['material_id' => $matA->id, 'quantity' => 4],
                ['material_id' => $matB->id, 'quantity' => 2],
            ],
            'description'    => 'Ruang briefing lantai 2',
        ];

        $response = $this->post('/pengambilan-barang', $payload);

        $response->assertRedirect(route('landing') . '#form-pengambilan');
        $matA->refresh();
        $matB->refresh();
        $this->assertEquals(16, $matA->quantity);
        $this->assertEquals(13, $matB->quantity);

        // Hanya 3 email yang dikirim (1 untuk masing-masing penerima, bukan 3 x 2 barang)
        Mail::assertSent(PengambilanBarangReceiptMail::class, 3);

        Mail::assertSent(PengambilanBarangReceiptMail::class, function ($mail) {
            $html = $mail->render();
            // Kedua material ada di dalam 1 email resi
            $this->assertStringContainsString('MAT-A-01', $html);
            $this->assertStringContainsString('Spidol Boardmarker Hitam', $html);
            $this->assertStringContainsString('4 Pcs', $html);
            $this->assertStringContainsString('16 Pcs', $html);

            $this->assertStringContainsString('MAT-B-02', $html);
            $this->assertStringContainsString('Penghapus Whiteboard', $html);
            $this->assertStringContainsString('2 Pcs', $html);
            $this->assertStringContainsString('13 Pcs', $html);

            return true;
        });
    }

    public function test_no_email_is_sent_if_stock_is_insufficient(): void
    {
        Mail::fake();
        $this->createTestUser();

        $material = Material::create([
            'material_number' => 'MAT-LOW-01',
            'name'            => 'Flashdisk 32GB',
            'quantity'        => 2,
            'unit'            => 'Pcs',
        ]);

        $payload = [
            'nama_pengambil' => 'Eko Prasetyo',
            'divisi'         => 'Enjiniring',
            'material_id'    => $material->id,
            'quantity'       => 10, // Melebihi stok
        ];

        $response = $this->post('/pengambilan-barang', $payload);

        $response->assertSessionHasErrors('quantity');
        $material->refresh();
        $this->assertEquals(2, $material->quantity);

        // Pastikan TIDAK ADA email yang terkirim
        Mail::assertNothingSent();
    }

    public function test_if_mail_sending_fails_receipt_is_saved_and_error_is_logged_without_duplication(): void
    {
        $this->createTestUser();

        $material = Material::create([
            'material_number' => 'MAT-ERR-01',
            'name'            => 'Map Folder Folio',
            'quantity'        => 50,
            'unit'            => 'Pcs',
        ]);

        // Simulasikan error pengiriman email dengan mock Mail facade
        Mail::shouldReceive('to')
            ->andReturnUsing(function () {
                throw new \RuntimeException('SMTP Connection Timeout ke mail server.');
            });

        Log::shouldReceive('error')
            ->atLeast()->once();

        $payload = [
            'nama_pengambil' => 'Dewi Sartika',
            'divisi'         => 'Logistik',
            'material_id'    => $material->id,
            'quantity'       => 5,
        ];

        $response = $this->post('/pengambilan-barang', $payload);

        // Transaksi pencatatan tetap berhasil dan resi ditampilkan
        $response->assertRedirect(route('landing') . '#form-pengambilan');
        $response->assertSessionHas('success_pengambilan');
        $response->assertSessionHas('receipt_data');
        $response->assertSessionHas('email_warning');

        // Stok tetap sukses berkurang
        $material->refresh();
        $this->assertEquals(45, $material->quantity);

        // Riwayat hanya tercatat 1 kali (tidak dobel)
        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $material->id,
            'quantity_change' => -5,
            'recipient'       => 'Dewi Sartika (Logistik)',
        ]);
        $this->assertEquals(1, StockMovement::where('material_id', $material->id)->count());
    }

    public function test_landing_page_renders_receipt_with_nama_pengambil_and_bagian(): void
    {
        $response = $this->withSession([
            'success_pengambilan' => 'Pengambilan barang berhasil disimpan!',
            'receipt_data' => [
                'date'            => '15 Oktober 2026, 09:30 WITA',
                'nama_pengambil'  => 'Indra Kusuma',
                'divisi'          => 'Operasi PLTU',
                'recipient'       => 'Indra Kusuma (Operasi PLTU)',
                'items'           => [
                    [
                        'material_number' => 'ATK-001',
                        'material_name'   => 'Baterai AA',
                        'qty_out'         => 4,
                        'unit'            => 'Pcs',
                        'remaining_stock' => 16,
                    ]
                ],
            ],
            'email_sent' => 'Bukti resi telah dikirimkan secara otomatis ke 3 alamat email admin.',
        ])->get('/');

        $response->assertStatus(200);
        $response->assertSee('BUKTI RESI PENGAMBILAN BARANG');
        $response->assertSee('Waktu Pencatatan:');
        $response->assertSee('15 Oktober 2026, 09:30 WITA');
        $response->assertSee('Nama Pengambil:');
        $response->assertSee('Indra Kusuma');
        $response->assertSee('Bagian:');
        $response->assertSee('Operasi PLTU');
        $response->assertSee('ATK-001');
        $response->assertSee('Baterai AA');
        $response->assertSee('4 Pcs');
        $response->assertSee('16 Pcs');
        $response->assertSee('finance.inventori@gmail.com');
        $response->assertSee('admin.inventoripln@gmail.com');
        $response->assertSee('general.inventoripln@gmail.com');
        $response->assertSee('Cetak Resi');
        $response->assertSee('Catat Pengambilan Baru');
    }
}
