<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KecamatanArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('slug', 'kecamatan')->firstOrFail();

        $realPhotos = $this->realPhotos();

        foreach ($this->data() as $item) {
            $slug = Str::slug('Kecamatan '.$item['nama']);
            $real = $realPhotos[$item['nama']] ?? null;

            $body = "<p>Kecamatan {$item['nama']} merupakan salah satu dari 33 kecamatan di wilayah Kabupaten Malang, Jawa Timur. {$item['deskripsi']}</p>"
                ."<p>Wilayah ini berada di kawasan {$item['wilayah']} Kabupaten Malang dengan potensi utama pada sektor {$item['potensi']}.</p>"
                .'<p><em>Catatan: artikel ini merupakan draf awal profil kecamatan yang dapat dilengkapi lebih lanjut oleh admin dengan data resmi dari kecamatan setempat, seperti jumlah desa, luas wilayah, jumlah penduduk, dan potensi unggulan terbaru.</em></p>';

            if ($real) {
                $body .= "<p class=\"text-sm text-gray-500\">{$real['image_credit']}</p>";
            }

            Article::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'title' => 'Kecamatan '.$item['nama'],
                    'excerpt' => Str::limit(strip_tags($item['deskripsi']), 160),
                    'body' => $body,
                    'cover_image' => $real['cover_image'] ?? "https://picsum.photos/seed/{$slug}/1200/700",
                    'gallery' => $real['gallery'] ?? [
                        "https://picsum.photos/seed/{$slug}-1/900/600",
                        "https://picsum.photos/seed/{$slug}-2/900/600",
                    ],
                    'meta' => [
                        'wilayah' => $item['wilayah'],
                        'potensi' => $item['potensi'],
                        'image_source' => $real ? 'wikimedia_commons' : 'placeholder',
                    ],
                    'status' => 'published',
                    'published_at' => now(),
                ]
            );
        }
    }

    /**
     * Beberapa kecamatan dengan landmark ikonik diberi foto asli dari Wikimedia Commons
     * (berlisensi Creative Commons, bebas pakai dengan syarat atribusi). Sisanya masih
     * memakai placeholder Lorem Picsum dan bisa diganti satu per satu dengan cara yang sama:
     * cari file di commons.wikimedia.org, lalu pakai URL stabil:
     * https://commons.wikimedia.org/wiki/Special:FilePath/Nama_File.jpg
     * Jangan lupa cantumkan kredit (lihat kolom meta.image_credit) di halaman terkait bila dipakai.
     */
    private function realPhotos(): array
    {
        return [
            'Singosari' => [
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Candi_Singosari_B.JPG?width=1200',
                'gallery' => [
                    'https://commons.wikimedia.org/wiki/Special:FilePath/Candi_Singosari_B.JPG?width=900',
                ],
                'image_credit' => 'Foto Candi Singosari — Wikimedia Commons, lisensi CC BY-SA 3.0.',
            ],
            'Bantur' => [
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Pura_Balekambang.png?width=1200',
                'gallery' => [
                    'https://commons.wikimedia.org/wiki/Special:FilePath/Pura_Balekambang.png?width=900',
                ],
                'image_credit' => 'Foto Pura Amerta Jati, Pantai Balekambang — Wikimedia Commons, lisensi CC BY-SA 3.0.',
            ],
            'Sumbermanjing Wetan' => [
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Pulau_Sempu_(Sempu_Island).jpg?width=1200',
                'gallery' => [
                    'https://commons.wikimedia.org/wiki/Special:FilePath/Pulau_Sempu_(Sempu_Island).jpg?width=900',
                ],
                'image_credit' => 'Foto Pulau Sempu, Sendang Biru — Wikimedia Commons, oleh Fortraihan, lisensi CC BY-SA 4.0.',
            ],
            'Poncokusumo' => [
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/TNBTS_Jemplang_Malang_Jatim.jpg?width=1200',
                'gallery' => [
                    'https://commons.wikimedia.org/wiki/Special:FilePath/TNBTS_Jemplang_Malang_Jatim.jpg?width=900',
                ],
                'image_credit' => 'Foto kawasan Taman Nasional Bromo Tengger Semeru, Jemplang, Poncokusumo — Wikimedia Commons, oleh Indiekreatif, lisensi CC BY-SA 4.0.',
            ],
            'Donomulyo' => [
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Pantai_Ngliyep_(Ngliyep_Beach_Donomulyo).jpg?width=1200',
                'gallery' => [
                    'https://commons.wikimedia.org/wiki/Special:FilePath/Pantai_Ngliyep_(Ngliyep_Beach_Donomulyo).jpg?width=900',
                ],
                'image_credit' => 'Foto Pantai Ngliyep, Donomulyo — Wikimedia Commons, oleh Angga Prastyo10, lisensi CC BY-SA 4.0.',
            ],
            'Tumpang' => [
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Candi_Jago_C.JPG?width=1200',
                'gallery' => [
                    'https://commons.wikimedia.org/wiki/Special:FilePath/Candi_Jago_C.JPG?width=900',
                ],
                'image_credit' => 'Foto Candi Jago, Tumpang — Wikimedia Commons, lisensi CC BY-SA 3.0.',
            ],
            'Pujon' => [
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Coban_Rondo_Waterfall.jpg?width=1200',
                'gallery' => [
                    'https://commons.wikimedia.org/wiki/Special:FilePath/Coban_Rondo_Waterfall.jpg?width=900',
                ],
                'image_credit' => 'Foto Air Terjun Coban Rondo, Pujon — Wikimedia Commons, lisensi CC BY-SA 2.0.',
            ],
        ];
    }

    private function data(): array
    {
        return [
            ['nama' => 'Ampelgading', 'wilayah' => 'pesisir selatan', 'potensi' => 'pertanian dan wisata pantai (Bajul Mati, Lenggoksono)', 'deskripsi' => 'Terletak di ujung tenggara Kabupaten Malang dengan garis pantai selatan yang masih asri dan potensi wisata bahari yang terus berkembang.'],
            ['nama' => 'Bantur', 'wilayah' => 'pesisir selatan', 'potensi' => 'pertanian dan wisata Pantai Balekambang', 'deskripsi' => 'Dikenal sebagai gerbang menuju Pantai Balekambang, salah satu pantai selatan paling populer di Kabupaten Malang dengan pura di tepi laut.'],
            ['nama' => 'Bululawang', 'wilayah' => 'tengah', 'potensi' => 'industri rumah tangga dan sentra tenun/sarung tradisional', 'deskripsi' => 'Kawasan tengah yang cukup padat penduduk, dikenal dengan aktivitas industri rumah tangga serta pertanian di sekitarnya.'],
            ['nama' => 'Dampit', 'wilayah' => 'selatan', 'potensi' => 'perkebunan kopi robusta', 'deskripsi' => 'Salah satu sentra penghasil kopi robusta unggulan Kabupaten Malang yang produknya mulai dikenal luas hingga pasar nasional.'],
            ['nama' => 'Dau', 'wilayah' => 'barat, dekat Kota Malang dan Kota Batu', 'potensi' => 'wisata alam dan pendidikan', 'deskripsi' => 'Berbatasan langsung dengan Kota Malang dan Kota Batu, memiliki hawa sejuk lereng pegunungan serta akses wisata alam seperti Coban Rondo di sekitarnya.'],
            ['nama' => 'Donomulyo', 'wilayah' => 'pesisir selatan', 'potensi' => 'pertanian dan wisata Pantai Ngliyep', 'deskripsi' => 'Wilayah pesisir selatan yang menjadi rumah bagi Pantai Ngliyep, salah satu destinasi wisata pantai tertua di Kabupaten Malang.'],
            ['nama' => 'Gedangan', 'wilayah' => 'pesisir selatan', 'potensi' => 'pertanian dan perikanan pesisir', 'deskripsi' => 'Kecamatan pesisir selatan dengan kombinasi lahan pertanian dan aktivitas perikanan masyarakat pantai.'],
            ['nama' => 'Gondanglegi', 'wilayah' => 'selatan-tengah', 'potensi' => 'perdagangan dan pertanian padi', 'deskripsi' => 'Dikenal sebagai salah satu pusat perdagangan dan pasar tradisional yang ramai di wilayah selatan-tengah Kabupaten Malang.'],
            ['nama' => 'Jabung', 'wilayah' => 'timur, lereng pegunungan Bromo Tengger', 'potensi' => 'agrowisata dan pertanian dataran tinggi', 'deskripsi' => 'Berada di lereng pegunungan timur dengan potensi agrowisata dan pertanian hortikultura dataran tinggi.'],
            ['nama' => 'Kalipare', 'wilayah' => 'barat daya', 'potensi' => 'pertanian dan perkebunan', 'deskripsi' => 'Wilayah agraris di bagian barat daya kabupaten yang berdekatan dengan kawasan waduk dan sungai Brantas.'],
            ['nama' => 'Karangploso', 'wilayah' => 'utara, dekat Kota Batu', 'potensi' => 'agrowisata dan pertanian hortikultura', 'deskripsi' => 'Kawasan sejuk di utara yang berbatasan dengan Kota Batu, berkembang sebagai kawasan agrowisata dan permukiman penyangga kota.'],
            ['nama' => 'Kasembon', 'wilayah' => 'barat, perbatasan Kabupaten Kediri', 'potensi' => 'wisata arung jeram Kali Konto', 'deskripsi' => 'Terkenal dengan wisata arung jeram di aliran Sungai Kali Konto yang menarik wisatawan pencinta petualangan air.'],
            ['nama' => 'Kepanjen', 'wilayah' => 'tengah', 'potensi' => 'pusat pemerintahan dan jasa', 'deskripsi' => 'Berperan sebagai ibu kota dan pusat pemerintahan Kabupaten Malang, sekaligus pusat perdagangan dan jasa yang terus berkembang.'],
            ['nama' => 'Kromengan', 'wilayah' => 'barat', 'potensi' => 'pertanian dan kawasan sekitar bendungan', 'deskripsi' => 'Wilayah agraris di bagian barat yang berdekatan dengan kawasan Bendungan Sutami/Karangkates.'],
            ['nama' => 'Lawang', 'wilayah' => 'utara', 'potensi' => 'perdagangan, bangunan kolonial, dan hawa sejuk lereng Arjuno', 'deskripsi' => 'Dikenal dengan hawa sejuk serta sejumlah bangunan bersejarah era kolonial peninggalan masa lampau.'],
            ['nama' => 'Ngajum', 'wilayah' => 'barat', 'potensi' => 'pertanian perbukitan', 'deskripsi' => 'Kawasan perbukitan di bagian barat dengan aktivitas pertanian dan perkebunan sebagai mata pencaharian utama warga.'],
            ['nama' => 'Ngantang', 'wilayah' => 'barat laut', 'potensi' => 'peternakan sapi perah dan wisata Waduk Selorejo', 'deskripsi' => 'Sentra peternakan sapi perah yang juga memiliki daya tarik wisata Waduk Selorejo dengan pemandangan pegunungan.'],
            ['nama' => 'Pagak', 'wilayah' => 'selatan', 'potensi' => 'pertanian lahan kering', 'deskripsi' => 'Wilayah selatan dengan karakter lahan kering yang dikembangkan untuk pertanian palawija dan perkebunan.'],
            ['nama' => 'Pagelaran', 'wilayah' => 'tengah-selatan', 'potensi' => 'pertanian', 'deskripsi' => 'Kawasan agraris yang berdekatan dengan pusat pemerintahan Kepanjen, didominasi lahan sawah dan pertanian rakyat.'],
            ['nama' => 'Pakis', 'wilayah' => 'timur, dekat Kota Malang', 'potensi' => 'industri dan pendidikan', 'deskripsi' => 'Wilayah padat penduduk yang berbatasan dengan Kota Malang, berkembang sebagai kawasan permukiman, industri, dan pendidikan.'],
            ['nama' => 'Pakisaji', 'wilayah' => 'tengah', 'potensi' => 'pertanian dan industri kecil', 'deskripsi' => 'Terletak berdekatan dengan Kepanjen, dikenal dengan aktivitas pertanian dan sejumlah industri kecil menengah.'],
            ['nama' => 'Poncokusumo', 'wilayah' => 'timur, lereng Gunung Semeru-Bromo', 'potensi' => 'agrowisata apel dan jalur pendakian', 'deskripsi' => 'Menjadi salah satu jalur menuju kawasan wisata Gunung Bromo dan Gunung Semeru, dengan potensi agrowisata petik apel dataran tinggi.'],
            ['nama' => 'Pujon', 'wilayah' => 'barat laut, dataran tinggi', 'potensi' => 'peternakan sapi perah dan agrowisata sayur', 'deskripsi' => 'Dikenal luas sebagai sentra susu sapi perah dan agrowisata sayuran dataran tinggi dengan udara pegunungan yang sejuk.'],
            ['nama' => 'Singosari', 'wilayah' => 'utara', 'potensi' => 'situs sejarah Candi Singosari dan industri', 'deskripsi' => 'Menyimpan situs bersejarah peninggalan Kerajaan Singhasari, sekaligus berkembang sebagai kawasan industri dan pendidikan.'],
            ['nama' => 'Sumbermanjing Wetan', 'wilayah' => 'pesisir selatan', 'potensi' => 'wisata Pantai Sendang Biru dan Pulau Sempu', 'deskripsi' => 'Menjadi pintu masuk menuju kawasan konservasi Pulau Sempu serta Pantai Sendang Biru yang menjadi pelabuhan nelayan.'],
            ['nama' => 'Sumberpucung', 'wilayah' => 'barat', 'potensi' => 'kawasan bendungan dan pertanian', 'deskripsi' => 'Berdekatan dengan kawasan Bendungan Sutami (Karangkates) yang berfungsi sebagai sumber energi dan irigasi wilayah sekitarnya.'],
            ['nama' => 'Tajinan', 'wilayah' => 'tengah', 'potensi' => 'pertanian', 'deskripsi' => 'Wilayah agraris di bagian tengah kabupaten dengan lahan pertanian sebagai penopang utama perekonomian warga.'],
            ['nama' => 'Tirtoyudo', 'wilayah' => 'pesisir selatan', 'potensi' => 'perkebunan kopi dan wisata air terjun', 'deskripsi' => 'Memiliki garis pantai selatan serta perbukitan yang menghasilkan kopi dan menyimpan sejumlah air terjun yang mulai dikembangkan sebagai wisata.'],
            ['nama' => 'Tumpang', 'wilayah' => 'timur', 'potensi' => 'wisata sejarah Candi Jago dan jalur wisata pegunungan', 'deskripsi' => 'Dikenal sebagai salah satu gerbang menuju kawasan wisata pegunungan timur, sekaligus menyimpan situs bersejarah Candi Jago.'],
            ['nama' => 'Turen', 'wilayah' => 'selatan-tengah', 'potensi' => 'wisata religi dan perdagangan', 'deskripsi' => 'Dikenal luas karena keberadaan kompleks masjid dan pondok pesantren yang menjadi tujuan wisata religi dari berbagai daerah.'],
            ['nama' => 'Wagir', 'wilayah' => 'barat, dekat Kota Malang', 'potensi' => 'pertanian dan perbukitan', 'deskripsi' => 'Kawasan perbukitan di sisi barat yang berbatasan dengan Kota Malang, dengan aktivitas pertanian sebagai mata pencaharian utama.'],
            ['nama' => 'Wajak', 'wilayah' => 'tenggara', 'potensi' => 'pertanian dan perkebunan', 'deskripsi' => 'Wilayah agraris di bagian tenggara yang berbatasan dengan kawasan pegunungan selatan Kabupaten Malang.'],
            ['nama' => 'Wonosari', 'wilayah' => 'barat', 'potensi' => 'perkebunan tebu dan pertanian', 'deskripsi' => 'Dikenal dengan aktivitas perkebunan tebu dan pertanian yang mendukung industri pengolahan hasil pertanian di sekitarnya.'],
        ];
    }
}
