<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaArticleSeeder extends Seeder
{
    /**
     * Ringkasan berita seputar Kabupaten Malang & Malang Raya, ditulis ulang
     * dengan kalimat sendiri (parafrase) berdasarkan riset dari berbagai media
     * publik -- BUKAN salinan/reproduksi artikel asli, sesuai batasan hak cipta.
     * Sumber disebutkan sebagai atribusi, bukan tautan langsung ke artikel asli.
     *
     * PENTING:
     * - Ini 21 berita, bukan 50 -- tidak ada berita yang dikarang untuk mengejar
     *   jumlah tertentu. Semua diverifikasi lewat pencarian web.
     * - Berita bisa jadi kadaluarsa/berubah (mis. status program, hasil akhir
     *   suatu kegiatan) -- admin perlu memverifikasi ulang sebelum publish.
     * - Semua artikel berstatus 'draft'.
     */
    public function run(): void
    {
        $category = Category::where('slug', 'berita')->first();

        if (! $category) {
            return; // jalankan BeritaCategorySeeder dulu
        }

        foreach ($this->data() as $item) {
            $slug = Str::slug($item['judul']);

            $body = $item['isi']
                ."<p class=\"text-sm text-gray-500\"><em>Sumber: {$item['sumber']} &middot; Peristiwa: {$item['tanggal']}. "
                .'Ringkasan ditulis ulang dengan kalimat sendiri, bukan kutipan langsung. '
                .'Admin perlu memverifikasi ulang sebelum dipublikasikan, terutama bila ada perkembangan lebih baru.</em></p>';

            Article::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'title' => $item['judul'],
                    'excerpt' => Str::limit(strip_tags($item['isi']), 160),
                    'body' => $body,
                    'cover_image' => self::PLACEHOLDER_IMAGE,
                    'gallery' => [],
                    'meta' => ['sumber' => $item['sumber'], 'tanggal_peristiwa' => $item['tanggal']],
                    'status' => 'draft',
                    'published_at' => null,
                ]
            );
        }
    }

    private const PLACEHOLDER_IMAGE = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0MDAgMjYwIj4KPHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyNjAiIGZpbGw9IiNFRkU5REMiLz4KPHJlY3QgeD0iNDAiIHk9IjYwIiB3aWR0aD0iMzIwIiBoZWlnaHQ9IjE0MCIgcng9IjgiIGZpbGw9IiMyRjRBMzQiLz4KPHJlY3QgeD0iNjAiIHk9IjgwIiB3aWR0aD0iMTgwIiBoZWlnaHQ9IjE0IiBmaWxsPSIjQzk4QTJDIi8+CjxyZWN0IHg9IjYwIiB5PSIxMDUiIHdpZHRoPSIyODAiIGhlaWdodD0iOCIgZmlsbD0iI0YzRUNERCIvPgo8cmVjdCB4PSI2MCIgeT0iMTIyIiB3aWR0aD0iMjYwIiBoZWlnaHQ9IjgiIGZpbGw9IiNGM0VDREQiLz4KPHJlY3QgeD0iNjAiIHk9IjEzOSIgd2lkdGg9IjIyMCIgaGVpZ2h0PSI4IiBmaWxsPSIjRjNFQ0REIi8+Cjx0ZXh0IHg9IjIwMCIgeT0iMjI4IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmb250LWZhbWlseT0iR2VvcmdpYSwgc2VyaWYiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiMzQjRBNTQiPkJlcml0YSBNYWxhbmc8L3RleHQ+Cjwvc3ZnPg==';

    private function data(): array
    {
        return [
            [
                'judul' => 'Kabupaten Malang Jadi Tuan Rumah Pembukaan MPLS Nasional 2026',
                'tanggal' => '13 Juli 2026',
                'sumber' => 'Malang Post / BeritaNasional.ID',
                'isi' => '<p>Kabupaten Malang dipercaya menjadi lokasi pembukaan nasional Masa Pengenalan Lingkungan Sekolah (MPLS) Tahun Ajaran 2026/2027, bertempat di SMK Negeri 2 Singosari pada Senin, 13 Juli 2026. Acara dibuka langsung oleh Menteri Pendidikan Dasar dan Menengah Abdul Mu\'ti, didampingi Bupati Malang H.M. Sanusi.</p><p>MPLS tahun ini mengusung konsep \'MPLS Ramah\' yang menekankan lingkungan belajar aman, nyaman, inklusif, serta bebas dari perpeloncoan dan perundungan, mengacu pada aturan baru yang memperpanjang masa MPLS dari tiga menjadi lima hari. Dalam kesempatan itu juga dideklarasikan sekolah bebas rokok konvensional maupun rokok elektrik, serta diserahkan SIKAP Awards 2026 kepada sekolah dan tenaga pendidik berprestasi dalam membangun budaya integritas.</p>',
            ],
            [
                'judul' => 'Kanjuruhan Holiday Fest 2026 Dongkrak UMKM, Bupati Ungkap Rencana Kawasan Kanjuruhan',
                'tanggal' => 'sekitar 4-12 Juli 2026',
                'sumber' => 'KabarBaik.co',
                'isi' => '<p>Festival Kanjuruhan Holiday Fest 2026 digelar selama 10 hari pada 4-12 Juli 2026, dimanfaatkan Pemkab Malang tidak hanya sebagai hiburan libur sekolah tapi juga sarana promosi produk UMKM setempat. Bupati Sanusi berharap kegiatan ini bisa menjadi agenda rutin setiap musim libur.</p><p>Dalam kesempatan itu, Bupati juga mengungkap rencana pengembangan kawasan sekitar Stadion Kanjuruhan di Kepanjen menjadi pusat ruang publik baru, termasuk pembangunan alun-alun dan Masjid Agung yang terintegrasi. Kawasan ini diproyeksikan menjadi pusat hiburan, kesenian, dan aktivitas masyarakat yang juga mendukung sektor pariwisata serta pertumbuhan UMKM.</p>',
            ],
            [
                'judul' => 'Bupati Sanusi Dorong Dekopinda Kabupaten Malang Semakin Maju',
                'tanggal' => '4 Juli 2026',
                'sumber' => 'JatimTimes',
                'isi' => '<p>Bupati Malang H.M. Sanusi menghadiri pengukuhan Pimpinan Dewan Koperasi Indonesia Daerah (Dekopinda) Kabupaten Malang periode 2025-2030, sekaligus rapat kerja dan sosialisasi perkoperasian, dalam rangkaian peringatan Hari Koperasi Indonesia ke-79. Acara berlangsung di Gedung Serbaguna PGRI Kabupaten Malang.</p><p>Bupati mendorong pengurus baru Dekopinda membawa iklim koperasi di Kabupaten Malang semakin maju, sehat, mandiri, dan terpercaya, khususnya demi memberi manfaat nyata bagi para anggotanya.</p>',
            ],
            [
                'judul' => 'Pemkab Malang Hibahkan Rp100 Juta ke KPU untuk Persiapan Pemilu 2026',
                'tanggal' => '2 Juli 2026',
                'sumber' => 'Jurnalis.co.id',
                'isi' => '<p>Pemerintah Kabupaten Malang menyerahkan hibah senilai Rp100 juta kepada KPU Kabupaten Malang untuk mendukung kegiatan non-tahapan dalam rangka persiapan Pemilu 2026. Bupati Sanusi menjelaskan dana ini tidak dipakai untuk pemungutan suara, melainkan untuk sosialisasi partisipasi pemilih, pemutakhiran data, serta pelatihan staf pendukung KPU.</p><p>Ketua KPU Kabupaten Malang Abdul Fatah mengapresiasi dukungan tersebut sebagai bentuk sinergi antara pemerintah daerah dan penyelenggara pemilu.</p>',
            ],
            [
                'judul' => 'Bupati Malang Ajak Pelaku Usaha Sukseskan Sensus Ekonomi 2026',
                'tanggal' => 'sekitar Mei-Juli 2026',
                'sumber' => 'Malang Inspirasi',
                'isi' => '<p>Bupati Malang H.M. Sanusi mengajak seluruh pelaku usaha di Kabupaten Malang, dari skala kecil hingga besar, untuk mendukung pelaksanaan Sensus Ekonomi 2026 yang digelar Badan Pusat Statistik setiap sepuluh tahun. Beliau berharap masyarakat menerima petugas BPS dengan baik dan memberikan data yang jujur.</p><p>Sensus berlangsung 1 Mei-31 Juli 2026, dengan tujuan memotret kondisi perekonomian daerah secara menyeluruh sebagai dasar perencanaan kebijakan ekonomi dan investasi ke depan.</p>',
            ],
            [
                'judul' => 'Bupati Sanusi Jadi Responden Pertama Sensus Ekonomi 2026 Kabupaten Malang',
                'tanggal' => '15 Juni 2026',
                'sumber' => 'Malang Inspirasi',
                'isi' => '<p>Sebagai simbol pencanangan awal Sensus Ekonomi (SE) 2026 di Kabupaten Malang, Bupati H.M. Sanusi didata lebih dulu oleh petugas BPS pada Senin, 15 Juni 2026, sebelum pendataan door-to-door ke masyarakat umum dimulai.</p><p>Pendataan usaha besar berlangsung Mei-Juni 2026 secara mandiri, sementara pendataan langsung oleh petugas berlangsung 15 Juni hingga 31 Agustus 2026. Bupati mengimbau warga memastikan identitas petugas dan memberi data akurat demi kebijakan ekonomi daerah yang tepat sasaran.</p>',
            ],
            [
                'judul' => 'Kejurcab IV Pagar Nusa 2026 Resmi Digelar di Kabupaten Malang',
                'tanggal' => '10-12 Juli 2026',
                'sumber' => 'Jatim Satu News',
                'isi' => '<p>Pengurus Cabang Pagar Nusa Kabupaten Malang menggelar Kejuaraan Cabang (Kejurcab) IV Pencak Silat Pagar Nusa 2026 selama tiga hari, 10-12 Juli 2026. Ajang ini sekaligus menjadi sarana menjaring atlet terbaik untuk persiapan Kejuaraan Wilayah dan Kejuaraan Nasional.</p><p>Bupati Malang H.M. Sanusi yang membuka kejuaraan ini mengingatkan bahwa pencak silat tak lepas dari pembentukan karakter dan akhlak, bukan sekadar ajang kompetisi fisik semata.</p>',
            ],
            [
                'judul' => 'Kadin Kabupaten Malang Studi Replika ke Kawasan Industri Terpadu Batang',
                'tanggal' => '16-18 Juli 2026',
                'sumber' => 'Disway Malang',
                'isi' => '<p>Kamar Dagang dan Industri (Kadin) Kabupaten Malang bersama jajaran Pemkab Malang dan Lembaga Kerja Sama Tripartit melakukan kunjungan kerja tiga hari ke Kawasan Industri Terpadu Batang (KITB) di Jawa Tengah, mulai 16 hingga 18 Juli 2026, untuk mempelajari tata kelola kawasan industri terpadu.</p><p>Rombongan dipimpin Sekretaris Daerah Kabupaten Malang bersama tim Disnaker dan DPMPTSP. Ketua Kadin Kabupaten Malang menyebut kerja sama ini sebagai langkah awal merealisasikan kawasan industri terpadu di Kabupaten Malang, proyek besar yang belum pernah ada sebelumnya, sekaligus membuka peluang integrasi dengan sektor pendidikan vokasi.</p>',
            ],
            [
                'judul' => 'Pemkab Malang Usulkan Perbaikan 3 Ruas Jalan Lewat Program IJD, Butuh Rp135 Miliar',
                'tanggal' => '17 Juli 2026',
                'sumber' => 'Kompas.com',
                'isi' => '<p>Pemkab Malang mengusulkan perbaikan tiga ruas jalan ke pemerintah pusat melalui program Inpres Jalan Daerah (IJD): ruas Kepanjen-Pagak, Kalipare-Donomulyo, dan akses ke Kampung Nelayan Merah Putih di Desa Pujiharjo, Kecamatan Tirtoyudo.</p><p>Kepala Dinas PU Bina Marga Kabupaten Malang menyebut tiga ruas ini jadi prioritas karena berfungsi sebagai akses penting peningkatan ekonomi masyarakat, dengan estimasi kebutuhan anggaran sekitar Rp135 miliar.</p>',
            ],
            [
                'judul' => 'Kabupaten Malang Dapat Program Unggulan Sekolah Terintegrasi',
                'tanggal' => 'awal 2026',
                'sumber' => 'Kecamatan Lawang / malangkab.go.id',
                'isi' => '<p>Kementerian Pendidikan Dasar dan Menengah menunjuk Kabupaten Malang sebagai salah satu daerah pelaksana program unggulan Presiden Prabowo Subianto, yaitu Sekolah Terintegrasi, yang menyatukan jenjang SD-SMP-SMA dalam satu kawasan.</p><p>Wakil Bupati Malang menyebut tiga sekolah yang disiapkan untuk program ini adalah SDN 4 Panggungrejo, SMPN 4 Kepanjen, dan SMAN 1 Kepanjen, disiapkan bersama Bappeda dan Dinas Pendidikan Kabupaten Malang.</p>',
            ],
            [
                'judul' => 'MPLS Ramah Warnai Tahun Ajaran Baru di Kabupaten Malang',
                'tanggal' => 'pertengahan 2026',
                'sumber' => 'Disway Malang',
                'isi' => '<p>Pelaksanaan Masa Pengenalan Lingkungan Sekolah (MPLS) tahun ajaran 2026/2027 di Kabupaten Malang mengusung konsep \'MPLS Ramah\', menekankan lingkungan belajar aman dan bebas perpeloncoan. Pendaftaran murid baru (PPDB) tahun ini dipersingkat dari lima menjadi empat tahap, berlangsung 11 Juni-4 Juli 2026 untuk jenjang SMP/MTs maupun SMA/SMK.</p><p>Meski regulasi baru dirancang untuk pengalaman yang aman, penerapannya di lapangan masih perlu pengawasan efektif dari dinas pendidikan dan keterlibatan aktif orang tua agar aturan larangan perpeloncoan dan pungutan liar benar-benar berjalan.</p>',
            ],
            [
                'judul' => 'Erlangga Setyo Pilih Nomor Punggung 16 di Arema FC',
                'tanggal' => '2026',
                'sumber' => 'Radar Malang',
                'isi' => '<p>Pemain Arema FC, Erlangga Setyo, resmi mengenakan nomor punggung 16 untuk kompetisi musim ini, menjadi bagian dari pembaruan skuad klub kebanggaan Malang Raya tersebut.</p>',
            ],
            [
                'judul' => 'Arema FC Lengkapi Tim Pelatih dengan Analis Performa Asal Brasil',
                'tanggal' => '2026',
                'sumber' => 'Radar Malang',
                'isi' => '<p>Arema FC merekrut Matheus Lacerda, analis performa asal Brasil, untuk melengkapi jajaran tim kepelatihan klub. Perekrutan ini menjadi bagian dari upaya manajemen memperkuat aspek analisis data dan performa pemain menuju kompetisi musim berikutnya.</p>',
            ],
            [
                'judul' => 'Prakiraan Cuaca Malang Raya: Cerah Terik Siang Hari, Kabut Pekat Berpotensi Malam',
                'tanggal' => '19 Juli 2026',
                'sumber' => 'beritajatim.com',
                'isi' => '<p>BMKG Juanda memperkirakan wilayah Malang Raya - meliputi Kota Malang, Kabupaten Malang, dan Kota Batu - didominasi cuaca cerah hingga cerah berawan pada Minggu, 19 Juli 2026, dengan suhu Kota Malang mencapai 30 derajat Celsius pada siang hari.</p><p>Sejumlah wilayah Kabupaten Malang, termasuk kawasan pesisir selatan seperti Bantur dan Donomulyo, diprediksi cerah terik siang hari, namun berpotensi diselimuti kabut pekat pada malam hingga dini hari yang dapat mengurangi jarak pandang. Kota Batu diprediksi mengalami suhu lebih dingin, berkisar 13-15 derajat Celsius pada malam hari.</p>',
            ],
            [
                'judul' => 'BMKG: Cuaca Kabupaten Malang Cerah Sepanjang Hari, Warga Diimbau Jaga Hidrasi',
                'tanggal' => '8 Juli 2026',
                'sumber' => 'Suara Desa',
                'isi' => '<p>BMKG memperkirakan cuaca di Kabupaten Malang pada Rabu, 8 Juli 2026, didominasi kondisi cerah sepanjang hari tanpa potensi hujan signifikan, dengan suhu berkisar 20-26 derajat Celsius dan kelembapan udara sekitar 75 persen.</p><p>Kondisi ini dinilai mendukung berbagai aktivitas masyarakat, mulai bekerja, bertani, hingga berwisata ke berbagai destinasi alam di Kabupaten Malang. BMKG tetap mengimbau warga menjaga hidrasi saat beraktivitas di luar ruangan siang hari serta memantau info cuaca terbaru lewat kanal resmi.</p>',
            ],
            [
                'judul' => 'Kekeringan dan Krisis Air Meluas di Sejumlah Titik Kabupaten Malang',
                'tanggal' => '2026',
                'sumber' => 'Radar Malang',
                'isi' => '<p>Sejumlah wilayah di Kabupaten Malang dilaporkan mengalami perluasan dampak kekeringan dan krisis air bersih, terutama di musim kemarau. Kondisi ini mendorong perhatian pemerintah daerah dan instansi terkait untuk memetakan wilayah terdampak serta menyiapkan langkah antisipasi pasokan air bersih bagi warga.</p>',
            ],
            [
                'judul' => 'Jalan Berlubang di Bululawang Sebabkan Kecelakaan',
                'tanggal' => '2026',
                'sumber' => 'Radar Malang',
                'isi' => '<p>Kondisi jalan berlubang di Jalan Raya Bakalan, Kecamatan Bululawang, Kabupaten Malang, dilaporkan menyebabkan kecelakaan pengendara. Warga berharap perbaikan infrastruktur jalan segera dilakukan untuk mencegah kejadian serupa terulang.</p>',
            ],
            [
                'judul' => 'Wendit Tempo Doeloe 2026 Resmi Dibuka, Bantengan dan 50 UMKM Ramaikan Wisata Wendit',
                'tanggal' => 'sekitar Juli 2026',
                'sumber' => 'Disway Malang',
                'isi' => '<p>Event bertajuk Wendit Tempo Doeloe 2026 resmi dibuka di kawasan wisata Wendit, Kecamatan Pakis, Kabupaten Malang. Acara ini menampilkan kesenian tradisional bantengan serta menghadirkan sekitar 50 pelaku UMKM lokal yang turut meramaikan suasana.</p><p>Kegiatan ini menjadi salah satu upaya menghidupkan kembali suasana nostalgia di kawasan Wendit sekaligus mendorong perputaran ekonomi pelaku usaha kecil di sekitar destinasi wisata tersebut.</p>',
            ],
            [
                'judul' => 'BPBD: 26 dari 33 Kecamatan di Kabupaten Malang Rawan Bencana Hidrometeorologi',
                'tanggal' => '2025-2026',
                'sumber' => 'Lentera.co',
                'isi' => '<p>BPBD Kabupaten Malang mencatat 26 dari total 33 kecamatan di wilayahnya rawan terhadap satu atau lebih jenis bencana hidrometeorologi, meliputi banjir/banjir bandang, angin puting beliung, dan tanah longsor. Untuk risiko banjir dan banjir bandang saja, BPBD mencatat 16 kecamatan berisiko, di antaranya Pujon, Ngantang, Kasembon, Karangploso, Dau, Singosari, Lawang, Pakis, Poncokusumo, Ampelgading, Tirtoyudo, Dampit, Sumbermanjing Wetan, Gedangan, Kalipare, dan Wagir.</p><p>Pemetaan ini disusun menyusul prakiraan BMKG akan potensi hujan intensitas sedang-lebat di Jawa Timur termasuk Kabupaten Malang, yang dapat memicu cuaca ekstrem seperti banjir, longsor, puting beliung, hingga hujan es.</p>',
            ],
            [
                'judul' => 'DTPHP Pastikan Pertanian Kabupaten Malang Belum Terdampak Kekeringan',
                'tanggal' => '22 Juni 2026',
                'sumber' => 'TIMES Indonesia',
                'isi' => '<p>Dinas Tanaman Pangan, Hortikultura, dan Perkebunan (DTPHP) Kabupaten Malang memastikan aktivitas pertanian di wilayahnya masih berjalan normal, karena sistem irigasi dinilai masih baik untuk suplai air ke lahan pertanian. Produksi padi dan komoditas hortikultura/perkebunan lain disebut masih berjalan sebagaimana mestinya.</p><p>Meski demikian, DTPHP tetap mewaspadai potensi dampak fenomena El Nino berintensitas tinggi yang menjadi isu kekeringan ekstrem secara nasional, dengan harapan Kabupaten Malang tidak terdampak signifikan.</p>',
            ],
            [
                'judul' => 'BPBD Kerja Bhakti Penanganan Tanah Longsor di Kecamatan Ngantang',
                'tanggal' => '2026',
                'sumber' => 'bpbd.malangkab.go.id',
                'isi' => '<p>BPBD Kabupaten Malang bersama warga dan instansi terkait melaksanakan kerja bhakti penanganan lokasi tanah longsor di Dusun Sumbersari, Desa Pagersari, Kecamatan Ngantang. Kegiatan ini merupakan bagian dari upaya mitigasi dan penanganan cepat pascabencana di wilayah rawan longsor.</p>',
            ],
        ];
    }
}
