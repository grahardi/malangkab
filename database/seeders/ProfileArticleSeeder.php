<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProfileArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('slug', 'profile')->firstOrFail();

        foreach ($this->data() as $item) {
            $slug = Str::slug($item['title']);

            Article::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'],
                    'body' => $item['body'],
                    'cover_image' => "https://picsum.photos/seed/{$slug}/1200/700",
                    'gallery' => [
                        "https://picsum.photos/seed/{$slug}-1/900/600",
                        "https://picsum.photos/seed/{$slug}-2/900/600",
                        "https://picsum.photos/seed/{$slug}-3/900/600",
                    ],
                    'status' => 'published',
                    'published_at' => now(),
                ]
            );
        }
    }

    private function data(): array
    {
        return [
            [
                'title' => 'Sejarah Kabupaten Malang',
                'excerpt' => 'Jejak panjang Kabupaten Malang, dari masa Kerajaan Kanjuruhan dan Singhasari hingga menjadi kabupaten modern di Jawa Timur.',
                'body' => "Kabupaten Malang memiliki akar sejarah yang sangat panjang, ditandai dengan keberadaan Prasasti Dinoyo yang menyebut Kerajaan Kanjuruhan pada abad ke-8 Masehi. Wilayah ini kemudian menjadi salah satu pusat penting Kerajaan Singhasari pada abad ke-13, yang jejaknya masih dapat dilihat melalui sejumlah candi peninggalan seperti Candi Singosari dan Candi Kidal.\n\nMemasuki masa kolonial, wilayah Malang berkembang sebagai daerah perkebunan dan pertanian yang subur berkat tanah vulkanik di sekitar Gunung Arjuno, Gunung Kawi, dan Gunung Semeru. Setelah kemerdekaan Indonesia, Kabupaten Malang ditetapkan sebagai daerah otonom yang terpisah dari Kotamadya Malang, dengan pusat pemerintahan yang kini berada di Kepanjen.\n\nHari jadi Kabupaten Malang diperingati setiap tanggal 28 November, merujuk pada penanggalan yang tercantum dalam Prasasti Dinoyo. Hingga kini, jejak sejarah tersebut terus dilestarikan melalui berbagai situs cagar budaya, museum, dan tradisi masyarakat yang masih hidup di tengah modernisasi daerah.",
            ],
            [
                'title' => 'Letak Geografis dan Wilayah Kabupaten Malang',
                'excerpt' => 'Mengenal posisi strategis, luas wilayah, dan bentang alam Kabupaten Malang yang mengelilingi Kota Malang dan Kota Batu.',
                'body' => "Kabupaten Malang merupakan salah satu kabupaten terluas di Provinsi Jawa Timur dengan luas wilayah lebih dari 3.500 kilometer persegi. Secara geografis, wilayah ini unik karena mengelilingi dua kota otonom sekaligus, yaitu Kota Malang dan Kota Batu, sehingga sering digambarkan berbentuk seperti huruf 'U' atau cincin di peta.\n\nWilayah Kabupaten Malang terbagi menjadi tiga karakter bentang alam utama: kawasan pegunungan di utara dan barat (termasuk lereng Gunung Arjuno-Welirang dan Gunung Kawi-Butak), kawasan dataran tinggi di timur yang berbatasan dengan lereng Gunung Semeru dan Gunung Bromo, serta kawasan pesisir selatan yang berhadapan langsung dengan Samudra Hindia.\n\nKombinasi bentang alam ini menjadikan Kabupaten Malang memiliki iklim yang beragam, mulai dari udara sejuk pegunungan hingga panas pesisir pantai selatan, serta potensi sumber daya alam yang kaya, mulai dari pertanian dataran tinggi, perkebunan, hingga perikanan laut.",
            ],
            [
                'title' => 'Pemerintahan dan Struktur Administrasi',
                'excerpt' => 'Struktur pemerintahan Kabupaten Malang yang terbagi ke dalam 33 kecamatan, dengan pusat pemerintahan di Kepanjen.',
                'body' => "Pusat pemerintahan Kabupaten Malang berada di Kepanjen, yang dijadikan ibu kota kabupaten sejak awal tahun 2000-an menggantikan fungsi administratif yang sebelumnya banyak berpusat di wilayah Kota Malang. Pemindahan ini bertujuan mempertegas batas administratif antara kabupaten dan kota, sekaligus mendorong pemerataan pembangunan.\n\nSecara administratif, Kabupaten Malang terbagi menjadi 33 kecamatan, yang selanjutnya terdiri dari ratusan desa dan beberapa kelurahan. Pemerintah kabupaten dipimpin oleh seorang Bupati dan Wakil Bupati yang dipilih melalui pemilihan kepala daerah, dibantu oleh Sekretaris Daerah beserta jajaran dinas dan badan teknis.\n\nBerbagai layanan publik seperti kependudukan, perizinan, kesehatan, dan pendidikan dikelola melalui dinas-dinas di lingkungan Pemerintah Kabupaten Malang, dengan dukungan sistem informasi daerah untuk mempermudah akses masyarakat terhadap data dan layanan pemerintahan.",
            ],
            [
                'title' => 'Visi dan Misi Pembangunan Daerah',
                'excerpt' => 'Arah pembangunan Kabupaten Malang menuju daerah yang mandiri, sejahtera, dan berdaya saing berbasis potensi lokal.',
                'body' => "Pembangunan Kabupaten Malang diarahkan untuk mewujudkan masyarakat yang mandiri, sejahtera, dan berdaya saing dengan tetap menjaga kelestarian lingkungan serta nilai-nilai budaya lokal. Arah kebijakan ini dituangkan dalam dokumen rencana pembangunan jangka panjang dan menengah daerah yang disusun bersama unsur pemerintah, DPRD, dan masyarakat.\n\nBeberapa fokus utama pembangunan meliputi penguatan sektor pertanian dan perkebunan sebagai tulang punggung ekonomi rakyat, pengembangan pariwisata berbasis alam dan budaya, peningkatan kualitas infrastruktur jalan dan konektivitas antarkecamatan, serta penguatan layanan pendidikan dan kesehatan hingga ke pelosok desa.\n\nSelain itu, tata kelola pemerintahan yang bersih, transparan, dan berbasis teknologi informasi terus didorong melalui digitalisasi layanan publik, dengan tujuan mempercepat proses perizinan usaha dan meningkatkan iklim investasi di daerah.",
            ],
            [
                'title' => 'Kependudukan dan Demografi',
                'excerpt' => 'Gambaran jumlah penduduk, sebaran wilayah, dan keragaman masyarakat Kabupaten Malang.',
                'body' => "Kabupaten Malang termasuk salah satu daerah dengan jumlah penduduk terbesar di Provinsi Jawa Timur, dengan populasi yang terus bertambah dari waktu ke waktu seiring pertumbuhan ekonomi dan migrasi penduduk. Sebaran penduduk tidak merata, dengan kepadatan lebih tinggi di kecamatan-kecamatan yang berbatasan langsung dengan Kota Malang dan Kota Batu, dibandingkan wilayah selatan yang lebih didominasi kawasan pertanian dan hutan.\n\nMasyarakat Kabupaten Malang sebagian besar merupakan suku Jawa dengan bahasa sehari-hari berupa Bahasa Jawa dialek Malangan, yang dikenal luas melalui tradisi unik 'boso walikan' atau bahasa terbalik yang menjadi identitas budaya khas wilayah Malang Raya.\n\nSelain penduduk asli, wilayah ini juga menjadi tempat tinggal masyarakat pendatang dari berbagai daerah di Indonesia, terutama yang bekerja di sektor pertanian, perkebunan, industri, serta pendidikan tinggi mengingat kedekatan wilayah dengan kawasan pendidikan di Kota Malang.",
            ],
            [
                'title' => 'Potensi Ekonomi, Pertanian, dan Perkebunan',
                'excerpt' => 'Kabupaten Malang sebagai lumbung pertanian dan perkebunan Jawa Timur dengan hasil unggulan apel, kopi, hingga tebu.',
                'body' => "Sektor pertanian dan perkebunan menjadi salah satu penopang utama perekonomian Kabupaten Malang. Wilayah dataran tinggi di kawasan barat dan utara, seperti area sekitar Poncokusumo, Pujon, dan Ngantang, dikenal sebagai penghasil apel, sayuran, dan produk susu segar berkat tanah vulkanik yang subur serta udara yang sejuk.\n\nDi wilayah selatan dan timur, seperti Dampit dan Tirtoyudo, masyarakat banyak membudidayakan kopi robusta yang kini semakin dikenal di pasar nasional maupun ekspor. Selain itu, komoditas tebu, cengkeh, dan tanaman perkebunan lain juga tumbuh subur di berbagai kecamatan, mendukung industri pengolahan hasil pertanian di daerah.\n\nSektor peternakan sapi perah turut menjadi kekuatan ekonomi khas Kabupaten Malang, khususnya di wilayah barat, yang menjadikan daerah ini sebagai salah satu produsen susu segar terbesar di Jawa Timur. Kombinasi sektor-sektor ini menjadikan Kabupaten Malang memiliki fondasi ekonomi agraris yang kuat dan berkelanjutan.",
            ],
            [
                'title' => 'Pariwisata Unggulan Kabupaten Malang',
                'excerpt' => 'Dari pantai selatan yang eksotis hingga wisata pegunungan, Kabupaten Malang menyimpan destinasi wisata yang lengkap.',
                'body' => "Kabupaten Malang dianugerahi kekayaan alam yang menjadikannya salah satu tujuan wisata favorit di Jawa Timur. Di wilayah selatan, terbentang garis pantai sepanjang puluhan kilometer dengan pasir putih dan tebing karang, seperti Pantai Balekambang, Pantai Ngliyep, dan Pantai Sendang Biru yang juga menjadi pintu penyeberangan menuju Pulau Sempu.\n\nDi wilayah barat dan utara, wisata alam pegunungan seperti kawasan air terjun (coban), agrowisata petik apel, serta wisata edukasi peternakan sapi perah menjadi daya tarik tersendiri bagi wisatawan keluarga. Sementara di sisi timur, kawasan menuju Gunung Bromo dan Gunung Semeru melalui jalur Poncokusumo menawarkan pengalaman wisata petualangan dan lanskap pegunungan yang megah.\n\nTidak hanya wisata alam, Kabupaten Malang juga memiliki wisata sejarah dan religi, seperti candi-candi peninggalan Kerajaan Singhasari serta berbagai masjid dan pesantren bersejarah, menjadikan pariwisata daerah ini kaya akan keragaman pengalaman.",
            ],
            [
                'title' => 'Kuliner Khas Kabupaten Malang',
                'excerpt' => 'Ragam kuliner khas yang menggambarkan cita rasa dan kekayaan bahan pangan lokal Kabupaten Malang.',
                'body' => "Kekayaan hasil pertanian dan perkebunan Kabupaten Malang turut melahirkan ragam kuliner khas yang menjadi daya tarik tersendiri. Apel hasil kebun lokal diolah menjadi berbagai produk olahan seperti keripik apel, jenang apel, hingga sari apel yang menjadi oleh-oleh khas dari kawasan dataran tinggi.\n\nDi wilayah pesisir selatan, hasil laut segar diolah menjadi berbagai hidangan seafood khas pesisir, sementara di wilayah pedesaan, kuliner tradisional berbahan dasar singkong, jagung, dan hasil kebun lainnya masih banyak dijumpai dalam kehidupan sehari-hari masyarakat.\n\nKopi robusta hasil perkebunan di wilayah selatan dan timur juga kini semakin populer dinikmati dalam bentuk kopi seduh khas daerah, sering disajikan di kedai-kedai kopi lokal yang tumbuh seiring meningkatnya kunjungan wisatawan ke Kabupaten Malang.",
            ],
            [
                'title' => 'Budaya dan Kesenian Tradisional',
                'excerpt' => 'Warisan budaya dan kesenian tradisional yang masih lestari di tengah masyarakat Kabupaten Malang.',
                'body' => "Kabupaten Malang memiliki kekayaan budaya yang tumbuh dari perpaduan tradisi Jawa dengan kekhasan lokal masyarakat Malang Raya. Salah satu identitas budaya paling dikenal adalah 'boso walikan Malang', yaitu tradisi berbahasa dengan membalik susunan huruf kata, yang berkembang sejak masa perjuangan dan masih digunakan dalam percakapan sehari-hari hingga kini.\n\nBerbagai kesenian tradisional seperti bantengan, jaranan, dan kuda lumping masih rutin dipentaskan dalam acara adat maupun peringatan hari besar di berbagai desa. Kesenian bantengan bahkan menjadi salah satu ikon budaya khas wilayah Malang yang menggabungkan unsur tari, musik, dan atraksi kekuatan spiritual dalam pertunjukannya.\n\nSelain itu, berbagai upacara adat dan sedekah desa masih dilestarikan sebagai bentuk syukur masyarakat atas hasil bumi, khususnya di wilayah pertanian dan pesisir, mencerminkan eratnya hubungan masyarakat Kabupaten Malang dengan alam dan tradisi leluhur.",
            ],
            [
                'title' => 'Pendidikan dan Fasilitas Umum',
                'excerpt' => 'Perkembangan layanan pendidikan, kesehatan, dan infrastruktur publik di seluruh wilayah Kabupaten Malang.',
                'body' => "Layanan pendidikan di Kabupaten Malang tersebar mulai dari jenjang pendidikan anak usia dini hingga sekolah menengah di hampir seluruh kecamatan, didukung oleh keberadaan pondok pesantren yang cukup banyak sebagai bagian dari tradisi pendidikan keagamaan masyarakat setempat. Kedekatan wilayah dengan Kota Malang, yang dikenal sebagai kota pendidikan, turut memberikan akses lebih luas bagi warga untuk melanjutkan pendidikan tinggi.\n\nDi sektor kesehatan, pemerintah daerah terus mengembangkan jaringan Puskesmas di setiap kecamatan serta rumah sakit daerah untuk menjangkau layanan kesehatan hingga wilayah pedesaan dan pesisir yang jaraknya cukup jauh dari pusat kota.\n\nSementara itu, pembangunan infrastruktur jalan, jembatan, serta jaringan air bersih terus menjadi prioritas untuk menghubungkan kecamatan-kecamatan di wilayah selatan yang secara geografis lebih terpencil, guna mendorong pemerataan akses ekonomi dan layanan publik di seluruh Kabupaten Malang.",
            ],
        ];
    }
}
