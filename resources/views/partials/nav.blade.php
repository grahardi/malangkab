<header class="bg-ijotebu text-putih-kapas sticky top-0 z-40 shadow-lg" style="color:#FBF8F2;">
    <div class="max-w-6xl mx-auto px-5 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <span class="w-9 h-9 rounded-full border-2 border-emas flex items-center justify-center font-display font-bold text-emas">M</span>
            <span class="font-display text-xl font-semibold tracking-tight">Malangkab<span class="text-emas">.com</span></span>
        </a>
        <nav class="hidden md:flex items-center gap-6 font-medium text-sm">
            <a href="{{ route('home') }}" class="hover:text-emas transition">Beranda</a>
            <a href="{{ route('category.show', 'profile') }}" class="hover:text-emas transition">Profil Daerah</a>
            <a href="{{ route('category.show', 'kecamatan') }}" class="hover:text-emas transition">33 Kecamatan</a>
            <a href="{{ route('category.show', 'pariwisata') }}" class="hover:text-emas transition">Pariwisata</a>
            <a href="{{ route('category.show', 'pendidikan') }}" class="hover:text-emas transition">Pendidikan</a>
            <a href="{{ route('category.show', 'tokoh') }}" class="hover:text-emas transition">Tokoh</a>
            <a href="{{ route('category.show', 'berita') }}" class="hover:text-emas transition">Berita</a>
        </nav>
        <a href="{{ route('category.show', 'pariwisata') }}" class="hidden md:inline-block bg-emas text-ijotebu2 text-sm font-semibold px-4 py-2 rounded-full hover:brightness-110 transition">
            Jelajahi Wisata
        </a>
    </div>
</header>
