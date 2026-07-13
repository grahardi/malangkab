# Malangkab.com — Addon Profil & Kecamatan

Paket ini berisi file tambahan untuk proyek **Laravel 13 (PHP 8.5 + PostgreSQL)** yang sudah Anda miliki. Isinya: migration, model, seeder (10 artikel kategori **Profile** + 33 artikel kategori **Kecamatan**), controller, route, dan view bertema majalah/profil daerah untuk malangkab.com.

> Catatan: paket ini file siap-pakai, bukan hasil `laravel new`. Anda tinggal menyalinnya ke proyek Laravel yang sudah berjalan.

## Struktur

```
app/Http/Controllers/ArticleController.php
app/Models/Category.php
app/Models/Article.php
database/migrations/2026_07_13_000001_create_categories_table.php
database/migrations/2026_07_13_000002_create_articles_table.php
database/seeders/CategorySeeder.php
database/seeders/ProfileArticleSeeder.php
database/seeders/KecamatanArticleSeeder.php
database/seeders/DatabaseSeeder.php   <- contoh, gabungkan ke DatabaseSeeder Anda
routes/web-additions.php              <- salin isinya ke routes/web.php
resources/views/layouts/app.blade.php
resources/views/partials/nav.blade.php
resources/views/partials/footer.blade.php
resources/views/home.blade.php
resources/views/articles/index.blade.php
resources/views/articles/show.blade.php
```

## Langkah instalasi ke proyek Anda

1. **Salin folder `app`, `database`, `resources` di paket ini ke root proyek Laravel Anda** (menimpa/menambah file, bukan mengganti folder yang sudah ada).
2. **Routing** — buka `routes/web.php`, ganti seluruh isinya mengikuti urutan di `routes/web.php.example` (di paket ini). **Urutan sangat penting**: grup route `admin` harus di paling atas, dan route catch-all publik (`{category}`, `{category}/{article}`) harus di paling bawah — kalau terbalik, `/admin/login` akan "ditelan" oleh route catch-all publik dan selalu 404. Kalau `routes/web.php` Anda sudah punya route lain di luar modul ini, cukup pastikan pola urutannya sama: **admin dulu, catch-all publik terakhir**.
3. **DatabaseSeeder** — buka `database/seeders/DatabaseSeeder.php` milik Anda, tambahkan pemanggilan:
   ```php
   $this->call([
       CategorySeeder::class,
       ProfileArticleSeeder::class,
       KecamatanArticleSeeder::class,
   ]);
   ```
4. **Migrasi & seed** (pastikan koneksi PostgreSQL di `.env` sudah benar):
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
5. Jalankan `php artisan serve` lalu buka `http://127.0.0.1:8000` — beranda, halaman `/profile`, `/kecamatan`, dan detail artikel per-kecamatan sudah aktif.

## Tentang gambar

Seeder memakai gambar placeholder dari **Lorem Picsum** (`picsum.photos`, layanan foto bebas pakai untuk pengembangan) berdasarkan seed nama artikel, supaya tiap artikel punya cover + galeri yang konsisten sejak awal.

**Kenapa tidak langsung ambil dari hasil pencarian Google Images?** Foto yang muncul di pencarian pada umumnya berhak cipta milik fotografer/situs asal — menaruhnya di situs publik tanpa izin berisiko pelanggaran hak cipta. Beberapa alternatif yang aman:

1. **Wikimedia Commons** — banyak foto landmark (candi, pantai, masjid, dsb.) berlisensi Creative Commons (bebas pakai dengan syarat mencantumkan atribusi). Sejauh ini **7 dari 33 kecamatan** sudah pakai foto asli terverifikasi lisensinya, lewat `KecamatanArticleSeeder::realPhotos()`:
   - Singosari → Candi Singosari (CC BY-SA 3.0)
   - Bantur → Pura Amerta Jati, Pantai Balekambang (CC BY-SA 3.0)
   - Sumbermanjing Wetan → Pulau Sempu (CC BY-SA 4.0)
   - Poncokusumo → kawasan Taman Nasional Bromo Tengger Semeru, Jemplang (CC BY-SA 4.0)
   - Donomulyo → Pantai Ngliyep (CC BY-SA 4.0)
   - Tumpang → Candi Jago (CC BY-SA 3.0)
   - Pujon → Air Terjun Coban Rondo (CC BY-SA 2.0)

   Untuk kecamatan lain: cari file di commons.wikimedia.org, lalu pakai URL stabil:
   ```
   https://commons.wikimedia.org/wiki/Special:FilePath/Nama_File.jpg
   ```
   Tambahkan entrinya ke method `realPhotos()` beserta teks kredit — sisanya otomatis terpasang saat seeding.
2. **Dokumentasi resmi Pemkab/Diskominfo Kabupaten Malang** — paling ideal karena biasanya sudah dimiliki hak pakainya oleh instansi terkait.
3. **Foto sendiri** per kecamatan, diunggah lewat storage Laravel (`php artisan storage:link`) dan diisi ke kolom `cover_image`/`gallery` sebagai path lokal.

## Seeder 100 artikel Pariwisata (Pariwisata100ArticleSeeder)

Mengisi 20 draf artikel di masing-masing 5 sub-kategori Pariwisata (Pantai, Wisata Alam, Wisata Religi & Budaya, Agrowisata & Wisata Buatan, Lainnya) — total 100 artikel.

**Semua artikel ini masuk dengan status `draft`, bukan langsung `published`.** Sebagian nama tempat (mis. Candi Kidal, Masjid Tiban, Waduk Selorejo, Pemandian Wendit) sudah cukup dikenal luas, tapi sebagian lain masih berupa starter/perkiraan yang perlu dicek admin — terutama kecamatan persis, jam operasional, harga tiket, dan detail teknis lainnya. Alur yang disarankan:

1. Jalankan `php artisan db:seed --class=Pariwisata100ArticleSeeder` (atau lewat `php artisan db:seed` penuh).
2. Buka **Admin → Manajemen Artikel**, filter kategori Pariwisata, lalu tinjau satu per satu.
3. Lengkapi/koreksi isi, ganti gambar placeholder Picsum dengan foto asli (lihat bagian "Tentang gambar" di atas), baru ubah status ke **Published**.

Gambar masih pakai placeholder Picsum untuk semua 100 artikel ini (belum ada foto asli terverifikasi per lokasi seperti pada seeder kecamatan) — silakan lengkapi manual di admin panel begitu foto resminya tersedia.

## Fitur Tokoh (Politik, Pendidikan, Masyarakat, Budayawan, Artis, Atlet, Lainnya)

Struktur (`TokohCategorySeeder`):

```
Tokoh (root)
  ├─ Tokoh Politik        (8 profil)
  ├─ Tokoh Pendidikan     (1 profil)
  ├─ Tokoh Masyarakat     (5 profil)
  ├─ Budayawan            (8 profil)
  ├─ Artis Malang         (15 profil)
  ├─ Atlet                (9 profil)
  └─ Tokoh Lainnya        (0 profil — belum ada nama yang bisa saya verifikasi)
```

**Total 46 profil**, bukan 80 seperti target awal permintaan. Saya sengaja tidak menambah nama karangan untuk mengejar angka — untuk orang sungguhan (apalagi tokoh publik nyata), fakta yang salah/dikarang bisa menyesatkan atau mencemarkan nama baik. Semua 46 nama di sini adalah tokoh nyata yang saya temukan dan verifikasi lewat riset (Wikipedia, media berita, situs resmi Pemkab Malang, jurnal akademik) — beberapa (H.M. Sanusi, Lathifah Shohib, Hamid Rusdi, Abdul Manan Wijaya, Mbah Rasimun, Mbah Karimoen, Mbah Misdi, Dendi Santoso, Syaiful Indra Cahya, Tarzan/Toto Mulyadi) terkonfirmasi langsung terkait kecamatan tertentu di **Kabupaten** Malang; sebagian besar lainnya tercatat sebagai tokoh "asal Malang" secara umum (bisa jadi Kota Malang, mengingat banyak tokoh terkenal memang dari sana).

**Sangat penting:**
- Isi tiap profil masih **garis besar/ringkasan**, bukan biografi lengkap. Detail seperti tanggal lahir presisi, riwayat karier lengkap, dan prestasi terbaru perlu dilengkapi & diverifikasi ulang admin — terutama untuk tokoh yang masih hidup/menjabat (jabatan publik bisa berubah).
- Semua 46 artikel berstatus **draft**.
- Foto pakai placeholder ikon siluet generik (bukan foto asli orangnya) untuk hampir semua profil — **baru 1 yang berhasil saya verifikasi lisensinya secara pasti dari Wikimedia Commons: Yuni Shara (CC BY-SA 4.0)**. Mengecek lisensi satu-per-satu untuk 46 orang ternyata sangat memakan waktu dan banyak file di Commons tidak menampilkan info lisensi jelas di hasil pencarian. Pola penambahannya sama seperti kecamatan/pariwisata: tambahkan entri baru ke `TokohArticleSeeder::realPhotos()` begitu menemukan foto lain yang lisensinya sudah pasti (jangan tempel foto tanpa cek lisensi).
- Kategori **Tokoh Lainnya** sengaja saya kosongkan karena belum menemukan nama yang bisa saya verifikasi masuk kategori ini secara meyakinkan.

**Menjalankan seeder ini:**
```bash
php artisan db:seed --class=TokohCategorySeeder
php artisan db:seed --class=TokohArticleSeeder
```

Kalau Anda ingin saya lanjutkan riset untuk melengkapi Tokoh Pendidikan (masih sangat tipis) atau Tokoh Lainnya, atau menambah lebih banyak nama di kategori lain, saya bisa lanjutkan pencarian — tapi saya tidak akan mengarang nama untuk sekadar mencapai target 80.

## Tampilan halaman Tokoh (kartu artikel langsung, bukan grid kategori)

Berbeda dari Pariwisata/Pendidikan, mengunjungi `/tokoh` **langsung menampilkan kartu profil tokoh** (dengan thumbnail) dari seluruh sub-kategori (Politik, Budayawan, Artis, dst) digabung jadi satu daftar berpaginasi — bukan grid sub-kategori dulu. Tiap kartu diberi label sub-kategorinya (mis. "Budayawan") supaya tetap jelas asal kategorinya. Logikanya ada di `ArticleController@category` (pengecualian khusus untuk slug `tokoh`).

## Sitemap XML untuk Google Search Console

Tersedia di `/sitemap.xml` — **dinamis**, dibangkitkan langsung dari data terbaru di database (halaman beranda + semua kategori + semua artikel published) setiap kali diakses lewat `SitemapController`. Tidak perlu digenerate ulang manual; otomatis mengikuti artikel baru/terhapus/berubah status.

**Submit ke Google Search Console:**
1. Buka [Google Search Console](https://search.google.com/search-console), pilih properti `malangkab.com`.
2. Menu **Sitemaps** → masukkan `sitemap.xml` → Submit.
3. (Opsional) tambahkan baris berikut ke `public/robots.txt`:
   ```
   Sitemap: https://malangkab.com/sitemap.xml
   ```

## Upload & unduh gambar ke storage lokal (bukan cuma paste URL)

Form artikel (create & edit) sekarang punya 3 cara mengisi gambar sampul maupun galeri:

1. **Paste URL manual** (cara lama, tetap ada) — gambar tetap di-hotlink ke server lain.
2. **Upload file** dari komputer Anda — untuk galeri bisa pilih banyak file sekaligus (upload massal).
3. **Unduh dari URL** — tempel URL gambar (galeri: banyak URL sekaligus, satu per baris), server yang mengunduh dan menyimpannya lokal di `storage/app/public/uploads`, jadi situs Anda **tidak hotlink** ke server orang lain.

Endpoint-nya: `POST /admin/media/upload` (multipart file) dan `POST /admin/media/fetch-urls` (JSON `{urls: "url1\nurl2"}`), dipanggil lewat JavaScript di form — hasil URL lokalnya otomatis mengisi field "Gambar Sampul" atau ditambahkan ke textarea galeri.

**Wajib dijalankan sekali di server** supaya file yang di-upload/diunduh bisa diakses lewat browser:
```bash
php artisan storage:link
```
Ini membuat symlink `public/storage` → `storage/app/public`. Tanpa ini, gambar akan ter-upload tapi URL-nya 404.

**Batasan yang saya terapkan** (bisa disesuaikan di `app/Http/Controllers/Admin/MediaController.php`):
- Maks 8MB per gambar, maks 20 file/URL per request.
- Hanya tipe gambar (jpg, png, webp, gif) — untuk "unduh dari URL", divalidasi lewat header `Content-Type` respons, bukan cuma ekstensi di URL.
- Ada peringatan di UI: mengunduh/upload gambar tidak otomatis memberi hak pakai — tetap pastikan Anda berhak memakainya.

## Fitur Pendidikan (TK/SD/SMP/SMA/SMK) — dimulai dari SMP

Struktur tree 3 tingkat (`PendidikanCategorySeeder`):

```
Pendidikan (root)
  ├─ TK, SD, SMA, SMK   (kategori kosong, menyusul)
  └─ SMP
       ├─ SMP Negeri 1 Ampelgading
       ├─ SMP Negeri 1 Bantur
       └─ ... (1 sekolah per 33 kecamatan)
```

Tiap sekolah adalah **kategori tersendiri** (bukan artikel tunggal), dengan 4 artikel di dalamnya (`SmpNegeri1ArticleSeeder`): **Profil, Statistik, Prestasi, Kontak Person**. Ini persis meniru struktur "sub-menu per sekolah" yang diminta — mengunjungi `/smp-negeri-1-bantur` menampilkan ke-4 artikel itu sebagai grid, sama seperti kategori lain.

**Sangat penting — ini semua TEMPLATE, bukan data asli:**
- Nama sekolah ("SMP Negeri 1 [Kecamatan]") memakai pola penamaan standar yang lazim di Indonesia, tapi **belum dikonfirmasi satu-satu** — sebagian kecamatan mungkin nama SMP negeri pertamanya berbeda dari pola ini.
- Alamat lengkap, jumlah siswa/guru, prestasi, dan nomor kontak **sengaja dikosongkan (diisi tanda `-`)**, bukan dikarang. Menyajikan angka palsu sebagai fakta soal sekolah negeri sungguhan berisiko menyesatkan.
- Galeri foto **tidak diisi** — sama seperti kasus foto wisata, mengambil foto sekolah dari Google Images berisiko hak cipta. Idealnya foto didapat langsung dari pihak sekolah.
- Semua 132 artikel (33 sekolah × 4 jenis) berstatus **draft**.

**Alur kerja yang disarankan:**
1. `php artisan db:seed --class=PendidikanCategorySeeder`
2. `php artisan db:seed --class=SmpNegeri1ArticleSeeder`
3. Konfirmasi dulu nama resmi tiap SMP Negeri 1 per kecamatan (kalau ternyata beda, edit nama kategorinya di **Admin → Manajemen Kategori**).
4. Lengkapi Statistik dari [dapo.kemdikbud.go.id](https://dapo.kemdikbud.go.id) (cari berdasarkan NPSN), lengkapi Profil/Kontak dari konfirmasi langsung ke sekolah, tambahkan galeri kalau sekolah menyediakan foto resmi.
5. Publish satu-satu lewat **Admin → Manajemen Artikel**, atau pakai tombol "Publish Semua Draft" per kategori kalau sudah yakin datanya benar.

### Tampilan kategori berisi sub-kategori (grid kartu, 3×3)

Kategori yang punya sub-kategori (Pariwisata → 5 sub, Pendidikan → 5 jenjang, SMP → 33 sekolah, dst) ditampilkan sebagai **grid kartu/box sederhana**, maksimal 9 per halaman (3 kolom × 3 baris), dengan paginasi bawaan Laravel. Ini menggantikan tampilan tree-dengan-preview-artikel sebelumnya, supaya kategori dengan banyak anak (seperti 33 sekolah SMP) tetap ringkas dan tidak jadi satu halaman yang sangat panjang. View-nya ada di `resources/views/articles/category-grid.blade.php`.

## Kartu kecamatan acak di beranda

Di beranda, bagian "Sekilas Kecamatan" menampilkan **6 kartu thumbnail kecamatan secara acak** (2 kolom × 3 baris), berbeda setiap kali halaman dimuat ulang — diambil lewat `Article::inRandomOrder()->limit(6)` di `ArticleController@home`. Daftar lengkap 33 kecamatan tetap bisa diakses di halaman `/kecamatan`.

## Admin Panel (AdminLTE 4)

Paket ini menambahkan panel admin di `/admin`, dibangun dengan **AdminLTE 4** (Bootstrap 5.3, tanpa jQuery) via CDN — tidak perlu install npm/composer package tambahan untuk tampilannya.

### Struktur kategori bertingkat (tree, seperti WordPress/Joomla)

Tabel `categories` sekarang punya kolom `parent_id`. Contoh struktur yang sudah di-seed:

```
Profile              (root, flat — tidak ada anak)
Kecamatan            (root, flat — tidak ada anak)
Pariwisata           (root)
  ├─ Pantai
  ├─ Air Terjun
  ├─ Gunung & Pendakian
  ├─ Wisata Religi & Budaya
  └─ Agrowisata & Wisata Buatan
```

Halaman **Manajemen Kategori** di admin menampilkan struktur ini sebagai tree dengan tombol tambah sub-kategori di tiap baris, persis pola WordPress/Joomla.

### 3 cara menambah artikel

Halaman **Artikel Baru** punya 3 tab di atas form:

1. **Manual** — isi form langsung.
2. **Scrape URL** — masukkan URL sumber, sistem mengambil judul/gambar/cuplikan teks via `ArticleScraperService` dan mengisi form secara otomatis. **Hasilnya wajib ditulis ulang dengan kalimat sendiri sebelum dipublikasikan** — ini konten mentah orang lain, bukan hasil akhir siap terbit (soal hak cipta).
3. **Generate AI** — masukkan topik, sistem memanggil Claude API lewat `AiArticleGenerator` untuk membuat draf judul/ringkasan/isi. Hasil AI **selalu masuk sebagai status Draft** dan wajib diverifikasi faktanya sebelum dipublikasikan (nama tempat, angka, sejarah, dll — model bisa saja salah).

### Langkah integrasi ke proyek Anda

1. Salin folder `app`, `database`, `resources`, `routes` ke proyek Laravel Anda (menambah, bukan mengganti yang sudah ada).
2. Ganti isi `routes/web.php` mengikuti `routes/web.php.example` — urutan admin-di-atas, catch-all-di-bawah (lihat poin routing di bagian atas README ini).
3. Daftarkan middleware `admin` di `bootstrap/app.php` (Laravel 11+/13):
   ```php
   ->withMiddleware(function (Illuminate\Foundation\Configuration\Middleware $middleware) {
       $middleware->alias([
           'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
       ]);
   })
   ```
4. Pastikan proyek Anda sudah punya sistem auth Laravel standar (tabel `users`, model `App\Models\User`). Jika belum ada login sama sekali, install Laravel Breeze (`composer require laravel/breeze` lalu `php artisan breeze:install blade`) agar tabel & model User siap — panel admin di sini memakai `Auth::attempt()` bawaan Laravel, bukan Breeze secara langsung, jadi Breeze opsional hanya untuk memastikan skema `users` ada.
5. Migrasi & seed:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
6. Login pertama kali di `/admin/login` dengan:
   - Email: `admin@malangkab.com`
   - Password: `ubah-password-ini`

   **Segera ganti password ini** setelah login (lewat `php artisan tinker` → `User::where('email','admin@malangkab.com')->first()->update(['password'=>Hash::make('password-baru-anda')])`), atau buat user admin sendiri lalu hapus/nonaktifkan akun default ini.

7. Untuk fitur **Generate AI**, tambahkan ke `.env`:
   ```
   ANTHROPIC_API_KEY=sk-ant-xxxxxxxx
   ANTHROPIC_MODEL=claude-sonnet-5
   ```
   dan ke `config/services.php`:
   ```php
   'anthropic' => [
       'key' => env('ANTHROPIC_API_KEY'),
       'model' => env('ANTHROPIC_MODEL', 'claude-sonnet-5'),
   ],
   ```
   Cek nama model API terbaru di [docs.claude.com](https://docs.claude.com) bila `claude-sonnet-5` sudah berganti.

### Catatan keamanan

- Middleware `admin` menolak akses (403) bagi user yang login tapi bukan admin (`is_admin = false`).
- Fitur scrape URL memakai `Http::get()` bawaan Laravel dengan timeout 15 detik — hanya untuk membaca halaman publik, bukan untuk situs yang butuh login.
- Jangan expose `ANTHROPIC_API_KEY` ke sisi klien (JS) — semua pemanggilan Claude API terjadi di server lewat `AiArticleGenerator`.

## Tentang konten

Isi 10 artikel "Profile" dan 33 artikel "Kecamatan" adalah **draf awal** (ringkasan umum, gaya ensiklopedis) yang aman dipakai sebagai starter content. Untuk data resmi (jumlah desa, luas wilayah, jumlah penduduk per kecamatan, potensi unggulan terbaru), sebaiknya dilengkapi dari data BPS Kabupaten Malang / Diskominfo agar akurat dan bisa diklaim sebagai data resmi pemerintah daerah.

## Menghubungkan ke GitHub

Saya tidak memiliki akses ke akun/repo GitHub Anda, jadi bagian ini perlu dijalankan dari sisi Anda (di terminal proyek Laravel Anda, setelah file di atas disalin masuk):

```bash
# jika proyek belum pernah di-init git
git init
git add .
git commit -m "Add profile & kecamatan magazine module for malangkab.com"

# hubungkan ke repo GitHub (buat dulu repo kosong di github.com jika belum ada)
git remote add origin https://github.com/USERNAME/NAMA-REPO.git
git branch -M main
git push -u origin main
```

Jika repo sudah ada dan sudah terhubung sebelumnya:
```bash
git add .
git commit -m "Add profile & kecamatan magazine module"
git push
```

Kalau Anda beri tahu saya nama repo GitHub-nya (atau hubungkan konektor GitHub di percakapan ini), saya bisa bantu susun isi commit/PR-nya juga.
