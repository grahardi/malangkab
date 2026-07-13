<footer class="bg-ijotebu2 text-gray-300 mt-20">
    <div class="max-w-6xl mx-auto px-5 py-12 grid md:grid-cols-3 gap-8">
        <div>
            <div class="font-display text-lg text-white font-semibold mb-2">Malangkab<span class="text-emas">.com</span></div>
            <p class="text-sm leading-relaxed">Portal profil dan majalah daerah Kabupaten Malang — merangkum sejarah, geografi, budaya, dan potensi 33 kecamatan.</p>
        </div>
        <div>
            <div class="text-white font-semibold mb-2 text-sm uppercase tracking-wider">Jelajahi</div>
            <ul class="space-y-1 text-sm">
                <li><a href="{{ route('category.show', 'profile') }}" class="hover:text-emas">Profil Kabupaten Malang</a></li>
                <li><a href="{{ route('category.show', 'kecamatan') }}" class="hover:text-emas">Daftar 33 Kecamatan</a></li>
            </ul>
        </div>
        <div>
            <div class="text-white font-semibold mb-2 text-sm uppercase tracking-wider">Tentang</div>
            <p class="text-sm">&copy; {{ date('Y') }} Malangkab.com. Konten berupa draf awal, dapat diperbarui dengan data resmi Pemerintah Kabupaten Malang.</p>
        </div>
    </div>
</footer>
