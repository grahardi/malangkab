@extends('layouts.app')

@section('content')
    {{-- HERO: motif kontur cincin pegunungan, menggambarkan bentuk wilayah Kab. Malang yang melingkari Kota Malang & Batu --}}
    <section class="bg-ijotebu contour-bg relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-5 py-20 md:py-28 grid md:grid-cols-2 gap-10 items-center relative z-10">
            <div>
                <span class="font-mono text-xs tracking-widest uppercase text-emas">33 Kecamatan · 1 Kabupaten</span>
                <h1 class="font-display text-4xl md:text-5xl font-bold text-white mt-3 leading-tight">
                    Kabupaten Malang,<br> tanah tinggi di antara gunung dan laut selatan.
                </h1>
                <p class="text-gray-200 mt-5 leading-relaxed max-w-md">
                    Dari lereng Arjuno hingga pesisir Samudra Hindia — jelajahi sejarah, budaya, dan potensi setiap sudut Kabupaten Malang.
                </p>
                <div class="mt-8 flex gap-3">
                    <a href="{{ route('category.show', 'profile') }}" class="bg-emas text-ijotebu2 font-semibold px-5 py-3 rounded-full hover:brightness-110 transition">Baca Profil Daerah</a>
                    <a href="{{ route('category.show', 'kecamatan') }}" class="border border-white/40 text-white font-semibold px-5 py-3 rounded-full hover:bg-white/10 transition">Lihat Kecamatan</a>
                </div>
            </div>
            {{-- Signature graphic: cincin topografi mewakili bentuk wilayah kabupaten --}}
            <div class="flex justify-center">
                <svg viewBox="0 0 320 320" class="w-64 h-64 md:w-80 md:h-80" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="160" cy="160" r="145" fill="none" stroke="#C98A2C" stroke-width="1.5" opacity="0.55"/>
                    <circle cx="160" cy="160" r="115" fill="none" stroke="#FBF8F2" stroke-width="1" opacity="0.35"/>
                    <circle cx="160" cy="160" r="85" fill="none" stroke="#C98A2C" stroke-width="1" opacity="0.4"/>
                    <circle cx="160" cy="160" r="55" fill="#23392A" stroke="#C98A2C" stroke-width="2"/>
                    <text x="160" y="155" text-anchor="middle" fill="#FBF8F2" font-family="Fraunces, serif" font-size="15" font-weight="700">KOTA</text>
                    <text x="160" y="175" text-anchor="middle" fill="#FBF8F2" font-family="Fraunces, serif" font-size="15" font-weight="700">MALANG</text>
                    <text x="160" y="30" text-anchor="middle" fill="#F3ECDD" font-family="JetBrains Mono, monospace" font-size="11">KAB. MALANG — 33 KECAMATAN MELINGKAR</text>
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

    {{-- Indeks bernomor 33 kecamatan — penomoran relevan karena ini benar memang daftar administratif berurutan --}}
    <section class="bg-ijotebu2 py-16">
        <div class="max-w-6xl mx-auto px-5">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="font-mono text-xs uppercase tracking-widest text-emas">Indeks Wilayah</span>
                    <h2 class="font-display text-2xl font-bold text-white mt-1">33 Kecamatan Kabupaten Malang</h2>
                </div>
                <a href="{{ route('category.show', 'kecamatan') }}" class="text-emas text-sm font-semibold hover:underline hidden sm:block">Lihat semua →</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                @foreach($kecamatanList as $i => $kec)
                    <a href="{{ route('article.show', ['kecamatan', $kec]) }}"
                       class="flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg px-4 py-3 transition">
                        <span class="font-mono text-emas text-xs">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="text-white text-sm">{{ str_replace('Kecamatan ', '', $kec->title) }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
