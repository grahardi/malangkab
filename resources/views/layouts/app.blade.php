<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Malangkab.com — Profil Kabupaten Malang')</title>
    <meta name="description" content="@yield('description', 'Profil lengkap Kabupaten Malang: sejarah, geografi, 33 kecamatan, pariwisata, budaya, dan potensi daerah.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700;9..144,900&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root{
            --ijo-tebu: #2F4A34;      /* hijau tebu tua - warna utama */
            --ijo-tebu-2: #23392A;
            --gading-kopi: #F3ECDD;   /* krem kopi susu - background */
            --kunyit-emas: #C98A2C;   /* emas kunyit - aksen/CTA */
            --tanah-liat: #A85333;    /* terakota tanah liat - aksen sekunder */
            --langit-senja: #3B4A54;  /* biru senja - teks gelap */
            --putih-kapas: #FBF8F2;
        }
        body{ background: var(--gading-kopi); color: var(--langit-senja); font-family:'Inter',sans-serif; }
        .font-display{ font-family:'Fraunces', serif; }
        .font-mono{ font-family:'JetBrains Mono', monospace; }
        .bg-ijotebu{ background: var(--ijo-tebu); }
        .bg-ijotebu2{ background: var(--ijo-tebu-2); }
        .text-emas{ color: var(--kunyit-emas); }
        .bg-emas{ background: var(--kunyit-emas); }
        .text-liat{ color: var(--tanah-liat); }
        .bg-liat{ background: var(--tanah-liat); }
        .border-emas{ border-color: var(--kunyit-emas); }
        .contour-bg{
            background-image: repeating-radial-gradient(circle at 15% 25%, rgba(251,248,242,0.06) 0, rgba(251,248,242,0.06) 1px, transparent 1px, transparent 22px),
                               repeating-radial-gradient(circle at 85% 70%, rgba(251,248,242,0.05) 0, rgba(251,248,242,0.05) 1px, transparent 1px, transparent 30px);
        }
        a:focus-visible, button:focus-visible { outline: 3px solid var(--kunyit-emas); outline-offset: 2px; }
    </style>
    @stack('head')
</head>
<body class="antialiased">
    @include('partials.nav')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
