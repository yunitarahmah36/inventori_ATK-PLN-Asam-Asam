<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $buku = [
            ['3726 MDPL', 'Nurwina Sari', 'Novel / Petualangan'],
            ['5 cm', 'Donny Dhirgantoro', 'Novel / Petualangan'],
            ['A Gentle Reminder', 'Bianca Sparacino', 'Pengembangan Diri'],
            ['Aksi Massa', 'Tan Malaka', 'Politik / Sejarah'],
            ['Analisis dan Visualisasi Data dengan Power BI dan Tableau', 'Jubilee Enterprise', 'Teknologi / Analisis Data'],
            ['Ancika: Dia yang Bersamaku Tahun 1995', 'Pidi Baiq', 'Novel / Romansa'],
            ['Atomic Habits', 'James Clear', 'Pengembangan Diri'],
            ['Bedebah di Ujung Tanduk', 'Tere Liye', 'Novel / Thriller'],
            ['Berani Tidak Disukai', 'Ichiro Kishimi & Fumitake Koga', 'Psikologi / Filsafat'],
            ['Bicara Itu Mudah: Rahasia Lancar Bicara dalam Sekejap', 'Aisyah Nafiani', 'Komunikasi'],
            ['Cantik Itu Luka', 'Eka Kurniawan', 'Novel / Sastra'],
            ['Dan Bandung', 'Pidi Baiq & Tim The PanasDalam Publishing', 'Novel'],
            ['Dilan 1983: Wo Ai Ni', 'Pidi Baiq', 'Novel'],
            ['Dunia Sophie: Sebuah Novel Filsafat', 'Jostein Gaarder', 'Novel / Filsafat'],
            ['Filosofi Teras', 'Henry Manampiring', 'Filsafat / Pengembangan Diri'],
            ['From Zero to Survive', 'Theo Derick', 'Motivasi'],
            ['Go Perpetuate: How to Beat the 3rd Generation Curse', 'Hadi Cahyadi', 'Bisnis / Manajemen'],
            ['How to Win Friends & Influence People', 'Dale Carnegie', 'Komunikasi'],
            ['Hujan', 'Tere Liye', 'Novel'],
            ['Janji', 'Tere Liye', 'Novel'],
            ['Jika Allah Berkehendak, Tak Ada yang Mustahil', 'Fuad Abdurahman', 'Agama / Motivasi'],
            ["Juz 'Amma: Terjemahan & Tajwid Warna", 'H. Arliansyah, S.S.', 'Agama'],
            ['Kado Terbaik', 'J. S. Khairen', 'Novel'],
            ['Laut Bercerita', 'Leila S. Chudori', 'Novel / Sejarah'],
            ['Love for Imperfect Things', 'Haemin Sunim', 'Pengembangan Diri'],
            ['Lukacita', 'Valerie Patkar', 'Novel'],
            ['MADILOG (Materialisme, Dialektika, dan Logika)', 'Tan Malaka', 'Filsafat'],
            ['Negeri Para Bedebah', 'Tere Liye', 'Novel / Thriller'],
            ['Ronggeng Dukuh Paruk', 'Ahmad Tohari', 'Novel / Sastra'],
            ['Sejarah Al-Quran yang Jarang Diungkapkan', 'Mohamad Jebara', 'Sejarah / Agama'],
            ['Sejarah Dunia yang Disembunyikan', 'Jonathan Black', 'Sejarah'],
            ['Seni Mengelola Emosi', 'In Hyun-Jin', 'Psikologi'],
            ['Seperti Dendam, Rindu Harus Dibayar Tuntas', 'Eka Kurniawan', 'Novel / Sastra'],
            ['Seporsi Mie Ayam Sebelum Mati', 'Brian Khrisna', 'Novel'],
            ['Si Paling NPD', 'Rizky A. Puspitasari', 'Psikologi'],
            ['Solo Leveling Vol. 10', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 12', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 13', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 14', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 15', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 17', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 18', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 2', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 3', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 4', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 5', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 6', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 8', 'Chugong', 'Komik / Fantasi'],
            ['Solo Leveling Vol. 9', 'Chugong', 'Komik / Fantasi'],
            ['Tan Malaka: Bapak Republik yang Dilupakan', 'Seri Buku Tempo', 'Biografi / Sejarah'],
            ['Tentang Kamu', 'Tere Liye', 'Novel'],
            ["The Alpha Girl's Guide", 'Henry Manampiring', 'Pengembangan Diri'],
            ['The Psychology of Money', 'Morgan Housel', 'Keuangan / Psikologi'],
            ['The Psychology of Women: Karena Wanita Ingin Mengerti dan Dimengerti', 'Nevzat Tarhan', 'Psikologi'],
            ['The Sacred History', 'Jonathan Black', 'Sejarah / Spiritual'],
            ['What I Talk About When I Talk About Running', 'Haruki Murakami', 'Memoar'],
        ];

        DB::transaction(function () use ($buku) {
            foreach ($buku as $index => $item) {
                $title = $item[0];

                $existing = DB::table('books')
                    ->where('title', $title)
                    ->first();

                $data = [
                    'title' => $title,
                    'author' => $item[1],
                    'category' => $item[2],
                ];

                if ($existing) {
                    // Perbarui informasi buku tanpa mengubah stok
                    // dan kode buku yang sudah ada.
                    DB::table('books')
                        ->where('id', $existing->id)
                        ->update(array_merge($data, [
                            'updated_at' => now(),
                        ]));

                    continue;
                }

                // Buat kode buku unik untuk data baru.
                $bookCode = 'BK-' . str_pad(
                    (string) ($index + 1),
                    3,
                    '0',
                    STR_PAD_LEFT
                );

                while (DB::table('books')
                    ->where('book_code', $bookCode)
                    ->exists()) {
                    $bookCode = 'BK-' . str_pad(
                        (string) random_int(100000, 999999),
                        6,
                        '0',
                        STR_PAD_LEFT
                    );
                }

                DB::table('books')->insert(array_merge($data, [
                    'book_code' => $bookCode,
                    'total_stock' => 1,
                    'available_stock' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        });
    }
}
