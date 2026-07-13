<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TokohArticleSeeder extends Seeder
{
    /**
     * Profil tokoh terkait Malang, disusun berdasarkan riset dari sumber publik
     * (Wikipedia, media berita, situs resmi Pemkab Malang, jurnal akademik, dsb).
     *
     * PENTING:
     * - Hanya memuat tokoh yang benar-benar bisa diverifikasi lewat sumber di atas.
     *   Tidak ada nama yang dikarang untuk mengejar jumlah tertentu.
     * - Isi tiap artikel MASIH RINGKAS/GARIS BESAR. Detail lebih lanjut (tanggal
     *   lahir lengkap, riwayat karier detail, prestasi terbaru) perlu dilengkapi
     *   dan diverifikasi ulang oleh admin sebelum dipublikasikan -- terutama untuk
     *   tokoh yang masih hidup/menjabat, karena informasi bisa berubah sewaktu-waktu.
     * - Semua artikel berstatus 'draft'.
     */
    public function run(): void
    {
        foreach ($this->data() as $categorySlug => $items) {
            $category = Category::where('slug', $categorySlug)->first();

            if (! $category) {
                continue; // jalankan TokohCategorySeeder dulu
            }

            foreach ($items as $item) {
                $slug = Str::slug($item['nama']);

                $body = "<p>{$item['ringkasan']}</p>"
                    .'<p><em>Catatan: profil ini masih berupa garis besar berdasarkan riset sumber publik. '
                    .'Admin perlu memverifikasi ulang dan melengkapi detail (tanggal lahir, riwayat lengkap, '
                    .'prestasi terbaru) sebelum dipublikasikan.</em></p>';

                Article::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'category_id' => $category->id,
                        'title' => $item['nama'],
                        'excerpt' => $item['ringkasan'],
                        'body' => $body,
                        'cover_image' => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0MDAgMjYwIj4KPHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyNjAiIGZpbGw9IiNFRkU5REMiLz4KPGNpcmNsZSBjeD0iMjAwIiBjeT0iMTA1IiByPSI1NSIgZmlsbD0iI0E4NTMzMyIvPgo8cGF0aCBkPSJNMTAwLDIzMCBDMTAwLDE2NSAxNDAsMTUwIDIwMCwxNTAgQzI2MCwxNTAgMzAwLDE2NSAzMDAsMjMwIFoiIGZpbGw9IiMyRjRBMzQiLz4KPHRleHQgeD0iMjAwIiB5PSIyNDgiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJHZW9yZ2lhLCBzZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzNCNEE1NCI+VG9rb2ggTWFsYW5nPC90ZXh0Pgo8L3N2Zz4=',
                        'gallery' => [],
                        'meta' => ['sumber' => 'riset_publik'],
                        'status' => 'draft',
                        'published_at' => null,
                    ]
                );
            }
        }
    }

    private function data(): array
    {
        return [
            'tokoh-politik' => [
                ['nama' => 'H.M. Sanusi', 'ringkasan' => 'Bupati Malang periode 2025-2030, dilantik langsung oleh Presiden Prabowo Subianto di Istana Negara pada 20 Februari 2025 bersama Wakil Bupati Lathifah Shohib.'],
                ['nama' => 'Lathifah Shohib', 'ringkasan' => 'Wakil Bupati Malang periode 2025-2030, dilantik bersama Bupati H.M. Sanusi oleh Presiden Prabowo Subianto pada 20 Februari 2025.'],
                ['nama' => 'KH Masjkur', 'ringkasan' => 'Ulama dan tokoh pergerakan kemerdekaan kelahiran Singosari, Kabupaten Malang, pada 30 Desember 1902. Berperan dalam peristiwa perobekan bendera Belanda di Hotel Yamato, Surabaya, serta aktif di BPUPKI dan PPKI menjelang kemerdekaan Indonesia.'],
                ['nama' => 'Widjojo Nitisastro', 'ringkasan' => 'Ekonom Indonesia yang pernah menjabat Menteri Koordinator Bidang Ekonomi, Keuangan, dan Industri (Menko Ekuin), tercatat dalam daftar tokoh asal Malang.'],
                ['nama' => 'Hadi Tjahjanto', 'ringkasan' => 'Panglima Tentara Nasional Indonesia ke-17, tercatat sebagai tokoh kelahiran Malang.'],
                ['nama' => 'Hamid Rusdi', 'ringkasan' => 'Pahlawan Nasional kelahiran Desa Sumbermanjing Kulon, Kecamatan Pagak, Kabupaten Malang, pada 1911. Memimpin perlawanan rakyat Malang pada masa revolusi kemerdekaan dan gugur dalam pertempuran melawan Belanda pada 1949.'],
                ['nama' => 'Abdul Manan Wijaya', 'ringkasan' => 'Pahlawan Nasional kelahiran Desa Ngroto, Kecamatan Pujon, Kabupaten Malang, pada 1915. Berjuang dalam gerakan kemerdekaan Indonesia dan mengakhiri karier militernya dengan pangkat Brigadir Jenderal.'],
                ['nama' => 'Acub Zainal', 'ringkasan' => 'Tokoh militer yang tercatat dalam daftar tokoh asal Malang.'],
            ],
            'tokoh-pendidikan' => [
                ['nama' => 'Theresia Widia Soerjaningsih', 'ringkasan' => 'Pendiri Bina Nusantara (BINUS), salah satu institusi pendidikan tinggi terkemuka di Indonesia, tercatat sebagai tokoh asal Malang.'],
            ],
            'tokoh-masyarakat' => [
                ['nama' => 'Mochtar Riady', 'ringkasan' => 'Pengusaha dan pendiri Lippo Group, salah satu konglomerasi bisnis besar di Indonesia, tercatat sebagai tokoh asal Malang.'],
                ['nama' => 'Mutiara Djokosoetono', 'ringkasan' => 'Pendiri Blue Bird Group, perusahaan transportasi taksi terbesar di Indonesia, tercatat sebagai tokoh asal Malang.'],
                ['nama' => 'Lucky Acub Zaenal', 'ringkasan' => 'Salah satu pendiri klub sepak bola Arema Indonesia, tercatat sebagai tokoh asal Malang.'],
                ['nama' => 'Mario Teguh', 'ringkasan' => 'Motivator dan pembicara publik yang dikenal luas di Indonesia lewat program-program pengembangan diri, tercatat sebagai tokoh asal Malang.'],
                ['nama' => 'William Wongso', 'ringkasan' => 'Pakar kuliner Indonesia yang dikenal luas lewat kiprahnya memperkenalkan masakan Nusantara, tercatat sebagai tokoh asal Malang.'],
            ],
            'tokoh-budayawan' => [
                ['nama' => 'Mbah Rasimun', 'ringkasan' => 'Maestro tari Topeng Malangan gaya Gunungsari, lahir di Dusun Glagahdowo, Desa Pulungdowo, Kecamatan Tumpang, Kabupaten Malang, pada 15 Juni 1932. Berjasa menyelamatkan seni Topeng Malangan dari kepunahan dan menerima berbagai penghargaan seni tradisi dari pemerintah.'],
                ['nama' => 'Mbah Karimoen (Karimun)', 'ringkasan' => 'Maestro topeng Malangan yang mengelola Sanggar/Padepokan Asmorobangun di Dusun Kedungmonggo, Kecamatan Pakisaji, Kabupaten Malang. Dikenal luas sebagai penerima penghargaan MURI atas dedikasinya melestarikan Topeng Malangan.'],
                ['nama' => 'Mbah Misdi', 'ringkasan' => 'Maestro Topeng Jabung Malangan asal Kecamatan Jabung, Kabupaten Malang, lahir sekitar tahun 1954. Puluhan tahun mengajar dan melatih tari topeng generasi muda hingga akhir hayatnya.'],
                ['nama' => 'A.M. Munardi', 'ringkasan' => 'Seniman-akademisi dari Akademi Seni Tari Indonesia Yogyakarta yang meneliti dan mendokumentasikan kesenian Topeng Malang.'],
                ['nama' => 'Robby Hidajat', 'ringkasan' => 'Dosen Jurusan Seni dan Desain, Fakultas Sastra, Universitas Negeri Malang, yang meneliti struktur, simbol, dan makna Wayang Topeng Malang.'],
                ['nama' => 'Dwi Cahyono', 'ringkasan' => 'Budayawan asal Malang, tercatat dalam daftar tokoh Malang.'],
                ['nama' => 'Ratna Indraswari Ibrahim', 'ringkasan' => 'Cerpenis asal Malang, tercatat dalam daftar tokoh Malang.'],
                ['nama' => 'Ki Soleh Adi Pramono', 'ringkasan' => 'Pemilik dan pengelola Padepokan Seni Mangun Dharma di Kecamatan Tumpang, Kabupaten Malang, berperan dalam kolaborasi seni dan akademik pelestarian Topeng Malangan.'],
            ],
            'tokoh-artis' => [
                ['nama' => 'Krisdayanti', 'ringkasan' => 'Penyanyi yang dikenal sebagai salah satu diva pop Indonesia, lahir di Malang.'],
                ['nama' => 'Yuni Shara', 'ringkasan' => 'Penyanyi asal Malang, kakak kandung Krisdayanti.'],
                ['nama' => 'Bayu Skak', 'ringkasan' => 'Aktor, komedian, sutradara, dan YouTuber asal Malang yang mengawali karier lewat konten video daring.'],
                ['nama' => 'Keisya Levronka', 'ringkasan' => 'Penyanyi asal Malang, dikenal luas lewat ajang pencarian bakat Indonesian Idol.'],
                ['nama' => 'Yuki Kato', 'ringkasan' => 'Aktris dan model kelahiran Malang.'],
                ['nama' => 'Dennis Adhiswara', 'ringkasan' => 'Aktor dan produser film asal Malang.'],
                ['nama' => 'Andhika Pratama', 'ringkasan' => 'Presenter, aktor, dan penyanyi yang lahir dan besar di Malang.'],
                ['nama' => 'Ririn Dwi Ariyanti', 'ringkasan' => 'Aktris sinetron dan film asal Malang.'],
                ['nama' => 'Feni Rose', 'ringkasan' => 'Pembawa acara televisi kelahiran Malang.'],
                ['nama' => 'Franda', 'ringkasan' => 'Presenter dan aktris asal Malang.'],
                ['nama' => 'Tarzan (Toto Mulyadi)', 'ringkasan' => 'Pelawak senior anggota grup Srimulat, lahir di Kepanjen, Kabupaten Malang, pada 24 April 1945.'],
                ['nama' => 'Meychan (Dita Anggraeni)', 'ringkasan' => 'Penyanyi asal Malang.'],
                ['nama' => 'Cindy Fatika Sari', 'ringkasan' => 'Artis sinetron dan film asal Malang.'],
                ['nama' => 'Sheila Marcia', 'ringkasan' => 'Artis dan model kelahiran Malang.'],
                ['nama' => 'Liza Natalia', 'ringkasan' => 'Presenter dan runner-up ajang Pemilihan Puteri Indonesia, asal Malang.'],
            ],
            'tokoh-atlet' => [
                ['nama' => 'Aji Santoso', 'ringkasan' => 'Mantan pemain sekaligus pelatih sepak bola nasional Indonesia, asal Kota Malang.'],
                ['nama' => 'Bambang Nurdiansyah', 'ringkasan' => 'Pesepak bola legendaris Indonesia asal Kota Malang.'],
                ['nama' => 'Dendi Santoso', 'ringkasan' => 'Pesepak bola kelahiran Sumberpucung, Kabupaten Malang, dikenal lewat kariernya bersama Arema FC.'],
                ['nama' => 'Syaiful Indra Cahya', 'ringkasan' => 'Pesepak bola kelahiran Bululawang, Kabupaten Malang.'],
                ['nama' => 'Rika Wijayanti', 'ringkasan' => 'Atlet paralayang (paragliding accuracy) asal Malang yang berprestasi di ajang internasional.'],
                ['nama' => 'Beny Wahyudi', 'ringkasan' => 'Pesepak bola asal Malang Raya.'],
                ['nama' => 'Hermawan', 'ringkasan' => 'Pesepak bola asal Malang Raya, dikenal sebagai kapten tim di beberapa klub.'],
                ['nama' => 'Kushedya Hari Yudo', 'ringkasan' => 'Pesepak bola asal Malang Raya.'],
                ['nama' => 'Dedik Setiawan', 'ringkasan' => 'Pesepak bola asal Malang Raya.'],
            ],
            'tokoh-lainnya' => [
            ],
        ];
    }
}
