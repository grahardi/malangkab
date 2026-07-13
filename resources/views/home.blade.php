@extends('layouts.app')

@section('content')
    {{-- HERO: ilustrasi gunung-laut-topeng khas Malang, menggantikan latar hijau polos --}}
    <section class="relative overflow-hidden" style="background:#12213A;">
        <svg viewBox="0 0 1280 560" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMax slice" class="absolute inset-0 w-full h-full">
            <defs>
                <linearGradient id="sky" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#12213A"/>
                    <stop offset="55%" stop-color="#5B3A5E"/>
                    <stop offset="80%" stop-color="#E07A3E"/>
                    <stop offset="100%" stop-color="#F3B24C"/>
                </linearGradient>
                <linearGradient id="sea" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#1F5C56"/>
                    <stop offset="100%" stop-color="#123B39"/>
                </linearGradient>
                <radialGradient id="sun" cx="50%" cy="50%" r="50%">
                    <stop offset="0%" stop-color="#FDE7A8" stop-opacity="0.95"/>
                    <stop offset="100%" stop-color="#FDE7A8" stop-opacity="0"/>
                </radialGradient>
            </defs>
            <rect x="0" y="0" width="1280" height="560" fill="url(#sky)"/>
            <circle cx="980" cy="230" r="140" fill="url(#sun)"/>
            <circle cx="980" cy="230" r="58" fill="#FBD675"/>
            <path d="M0,300 L120,190 L230,300 L330,210 L470,300 L620,170 L760,300 L900,220 L1050,300 L1180,200 L1280,300 L1280,420 L0,420 Z" fill="#2F4A55" opacity="0.55"/>
            <path d="M0,340 L160,240 L300,340 L430,250 L600,340 L780,230 L950,340 L1120,260 L1280,340 L1280,440 L0,440 Z" fill="#22343E" opacity="0.85"/>
            <rect x="0" y="400" width="1280" height="160" fill="url(#sea)"/>
            <path d="M0,415 Q160,400 320,415 T640,415 T960,415 T1280,415" stroke="#EAF4F1" stroke-opacity="0.35" stroke-width="3" fill="none"/>
            <path d="M0,445 Q160,430 320,445 T640,445 T960,445 T1280,445" stroke="#EAF4F1" stroke-opacity="0.25" stroke-width="3" fill="none"/>
            <path d="M0,475 Q160,460 320,475 T640,475 T960,475 T1280,475" stroke="#EAF4F1" stroke-opacity="0.18" stroke-width="3" fill="none"/>
            <g transform="translate(70,330)" opacity="0.9">
                <path d="M0,90 C-4,40 10,0 22,-10 C34,0 48,40 44,90 Z" fill="#1B4B3A"/>
                <path d="M-30,60 C-24,30 -6,14 22,4" stroke="#1B4B3A" stroke-width="6" fill="none" stroke-linecap="round"/>
                <path d="M74,60 C68,30 50,14 22,4" stroke="#1B4B3A" stroke-width="6" fill="none" stroke-linecap="round"/>
            </g>
        </svg>

        <div class="absolute inset-0" style="background:linear-gradient(90deg, rgba(18,33,58,0.85) 0%, rgba(18,33,58,0.35) 55%, rgba(18,33,58,0.05) 100%);"></div>

        <div class="max-w-6xl mx-auto px-5 py-20 md:py-28 grid md:grid-cols-2 gap-10 items-center relative z-10">
            <div>
                <span class="font-mono text-xs tracking-widest uppercase text-emas">33 Kecamatan · 1 Kabupaten</span>
                <h1 class="font-display text-4xl md:text-5xl font-bold text-white mt-3 leading-tight" style="text-shadow:0 2px 12px rgba(0,0,0,.35)">
                    Kabupaten Malang,<br> tanah tinggi di antara gunung dan laut selatan.
                </h1>
                <p class="text-gray-100 mt-5 leading-relaxed max-w-md" style="text-shadow:0 1px 6px rgba(0,0,0,.4)">
                    Dari lereng Arjuno hingga pesisir Samudra Hindia — jelajahi sejarah, budaya, dan potensi setiap sudut Kabupaten Malang.
                </p>
                <div class="mt-8 flex gap-3">
                    <a href="{{ route('category.show', 'profile') }}" class="bg-emas text-ijotebu2 font-semibold px-5 py-3 rounded-full hover:brightness-110 transition">Baca Profil Daerah</a>
                    <a href="{{ route('category.show', 'kecamatan') }}" class="border border-white/50 text-white font-semibold px-5 py-3 rounded-full hover:bg-white/10 transition">Lihat Kecamatan</a>
                </div>
            </div>

            {{-- Aksen budaya: ilustrasi topeng Malangan bergaya sederhana, bukan reproduksi karya spesifik --}}
            <div class="flex justify-center md:justify-end">
                <svg viewBox="0 0 260 260" class="w-52 h-52 md:w-64 md:h-64 drop-shadow-xl" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="130" cy="130" r="120" fill="#C98A2C" opacity="0.15"/>
                    <circle cx="130" cy="130" r="95" fill="none" stroke="#C98A2C" stroke-width="2" opacity="0.6"/>
                    <path d="M130 55 C90 55 68 90 68 130 C68 175 95 205 130 205 C165 205 192 175 192 130 C192 90 170 55 130 55 Z" fill="#E8DCC4"/>
                    <path d="M85 108 C95 92 118 90 130 100 C142 90 165 92 175 108" stroke="#A85333" stroke-width="6" fill="none" stroke-linecap="round"/>
                    <circle cx="102" cy="122" r="9" fill="#23392A"/>
                    <circle cx="158" cy="122" r="9" fill="#23392A"/>
                    <path d="M118 148 Q130 158 142 148" stroke="#A85333" stroke-width="5" fill="none" stroke-linecap="round"/>
                    <path d="M96 165 Q130 182 164 165" stroke="#C98A2C" stroke-width="4" fill="none" stroke-linecap="round" opacity="0.8"/>
                    <text x="130" y="238" text-anchor="middle" fill="#F3ECDD" font-family="JetBrains Mono, monospace" font-size="12">TOPENG MALANGAN</text>
                </svg>
            </div>
        </div>
    </section>

    {{-- Profil unggulan --}}
    @if($profileHighlight)
    <section class="max-w-6xl mx-auto px-5 -mt-10 relative z-10">
        <a href="{{ route('article.show', ['profile', $profileHighlight]) }}" class="block bg-putih-kapas rounded-2xl shadow-xl overflow-hidden md:flex" style="background:#FBF8F2;">
            <img src="{{ $profileHighlight->cover_image }}" alt="{{ $profileHighlight->title }}" class="md:w-1/2 h-56 md:h-auto object-cover">
            <div class="p-8 md:w-1/2">
                <span class="font-mono text-xs uppercase tracking-widest text-liat">Profil Pilihan</span>
                <h2 class="font-display text-2xl font-bold mt-2">{{ $profileHighlight->title }}</h2>
                <p class="mt-3 text-sm leading-relaxed text-gray-600">{{ $profileHighlight->excerpt }}</p>
                <span class="inline-block mt-4 text-sm font-semibold text-liat">Baca selengkapnya →</span>
            </div>
        </a>
    </section>
    @endif

    {{-- Artikel terbaru --}}
    <section class="max-w-6xl mx-auto px-5 py-16">
        <div class="flex items-end justify-between mb-6">
            <h2 class="font-display text-2xl font-bold">Artikel Terbaru</h2>
        </div>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($latest as $article)
                <a href="{{ route('article.show', [$article->category->slug, $article]) }}" class="group block bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                    <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-40 object-cover">
                    <div class="p-5">
                        <span class="font-mono text-[11px] uppercase tracking-widest text-liat">{{ $article->category->name }}</span>
                        <h3 class="font-display font-semibold mt-1 group-hover:text-liat transition">{{ $article->title }}</h3>
                        <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $article->excerpt }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Kartu thumbnail 6 destinasi Pariwisata acak (2 kolom x 3 baris). Tampil di ATAS modul Kecamatan. --}}
    <section class="bg-liat py-16" style="background:#A85333;">
        <div class="max-w-6xl mx-auto px-5">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="font-mono text-xs uppercase tracking-widest text-white/80">Jelajah Wisata</span>
                    <h2 class="font-display text-2xl font-bold text-white mt-1">Sekilas Pariwisata</h2>
                    <p class="text-white/80 text-sm mt-1">Pantai, air terjun, gunung, hingga wisata religi — tampil acak dari seluruh sub-kategori Pariwisata.</p>
                </div>
                <a href="{{ route('category.show', 'pariwisata') }}" class="text-white text-sm font-semibold hover:underline hidden sm:block whitespace-nowrap">Lihat semua kategori →</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                @foreach($pariwisataRandom as $item)
                    <a href="{{ route('article.show', [$item->category->slug, $item]) }}"
                       class="group flex items-center gap-4 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl p-3 transition">
                        <img src="{{ $item->cover_image }}" alt="{{ $item->title }}" class="w-24 h-20 md:w-28 md:h-24 object-cover rounded-lg flex-shrink-0">
                        <div class="min-w-0">
                            <span class="font-mono text-[10px] uppercase tracking-widest text-white/70">{{ $item->category->name }}</span>
                            <h3 class="text-white font-display font-semibold group-hover:text-emas transition truncate">{{ $item->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>

            <a href="{{ route('category.show', 'pariwisata') }}" class="mt-6 inline-block text-white text-sm font-semibold hover:underline sm:hidden">Lihat semua kategori wisata →</a>
        </div>
    </section>

    {{-- Kartu thumbnail 6 kecamatan acak (2 kolom x 3 baris). Berganti tiap halaman dimuat ulang. --}}
    <section class="bg-ijotebu2 py-16">
        <div class="max-w-6xl mx-auto px-5">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="font-mono text-xs uppercase tracking-widest text-emas">Jelajah Wilayah</span>
                    <h2 class="font-display text-2xl font-bold text-white mt-1">Sekilas Kecamatan</h2>
                    <p class="text-gray-300 text-sm mt-1">Kabupaten Malang punya 33 kecamatan — ini 6 di antaranya, tampil acak.</p>
                </div>
                <a href="{{ route('category.show', 'kecamatan') }}" class="text-emas text-sm font-semibold hover:underline hidden sm:block whitespace-nowrap">Lihat semua 33 →</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                @foreach($kecamatanRandom as $kec)
                    <a href="{{ route('article.show', ['kecamatan', $kec]) }}"
                       class="group flex items-center gap-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl p-3 transition">
                        <img src="{{ $kec->cover_image }}" alt="{{ $kec->title }}" class="w-24 h-20 md:w-28 md:h-24 object-cover rounded-lg flex-shrink-0">
                        <div class="min-w-0">
                            <h3 class="text-white font-display font-semibold group-hover:text-emas transition truncate">{{ $kec->title }}</h3>
                            <p class="text-gray-400 text-xs mt-1 line-clamp-2">{{ $kec->excerpt }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <a href="{{ route('category.show', 'kecamatan') }}" class="mt-6 inline-block text-emas text-sm font-semibold hover:underline sm:hidden">Lihat semua 33 kecamatan →</a>
        </div>
    </section>
@endsection
