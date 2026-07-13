@extends('admin.layouts.app')

@section('title', 'Artikel Baru')

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-manual" type="button">✍️ Manual</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-scrape" type="button">🔗 Scrape URL</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-ai" type="button">🤖 Generate AI</button>
            </li>
        </ul>
    </div>
    <div class="card-body tab-content">
        <div class="tab-pane fade show active" id="tab-manual">
            <p class="text-muted mb-0">Isi langsung form di bawah, lalu klik <strong>Simpan Artikel</strong>.</p>
        </div>

        <div class="tab-pane fade" id="tab-scrape">
            <div class="input-group mb-2">
                <input type="url" id="scrapeUrl" class="form-control" placeholder="https://sumber-referensi.com/artikel-tempat-wisata">
                <button type="button" id="btnScrape" class="btn btn-outline-secondary">Ambil Konten</button>
            </div>
            <div class="alert alert-warning small mb-0" id="scrapeNotice" style="display:none"></div>
            <div class="text-muted small mt-2">
                Konten yang diambil hanya draf mentah dari sumber lain. <strong>Wajib ditulis ulang dengan kalimat sendiri</strong>
                sebelum status diubah ke "Published" — jangan menyalin-tempel utuh, ini soal hak cipta.
            </div>
        </div>

        <div class="tab-pane fade" id="tab-ai">
            <div class="mb-2">
                <label class="form-label small">Topik artikel</label>
                <input type="text" id="aiTopic" class="form-control" placeholder="mis. Wisata Pantai Goa Cina">
            </div>
            <div class="mb-2">
                <label class="form-label small">Konteks tambahan (opsional)</label>
                <textarea id="aiContext" class="form-control" rows="2" placeholder="mis. lokasi di Sumbermanjing Wetan, fokuskan ke akses & daya tarik"></textarea>
            </div>
            <button type="button" id="btnGenerateAi" class="btn btn-outline-secondary">Generate Draf</button>
            <div class="alert alert-warning small mt-2 mb-0" id="aiNotice" style="display:none"></div>
            <div class="text-muted small mt-2">
                Perlu <code>ANTHROPIC_API_KEY</code> terisi di <code>.env</code> proyek Anda. Hasil AI selalu masuk sebagai
                draf — <strong>verifikasi faktanya</strong> sebelum dipublikasikan.
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title mb-0">Detail Artikel</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.articles.store') }}" id="articleForm">
            @csrf
            @include('admin.articles._form', ['article' => null])
            <button class="btn btn-malang">Simpan Artikel</button>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('btnScrape').addEventListener('click', async function () {
    const url = document.getElementById('scrapeUrl').value.trim();
    if (!url) return;
    this.disabled = true; this.textContent = 'Mengambil...';
    try {
        const res = await fetch('{{ route('admin.articles.scrape') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': window.csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ url })
        });
        const json = await res.json();
        if (!json.ok) throw new Error(json.message || 'Gagal mengambil konten');
        const d = json.data;
        document.querySelector('[name=title]').value = d.title || '';
        document.querySelector('[name=excerpt]').value = d.excerpt || '';
        document.querySelector('[name=cover_image]').value = d.image || '';
        document.querySelector('[name=body]').value = d.raw_paragraphs.map(p => `<p>${p}</p>`).join('\n');
        const notice = document.getElementById('scrapeNotice');
        notice.style.display = 'block';
        notice.textContent = d.notice;
    } catch (e) {
        alert(e.message);
    } finally {
        this.disabled = false; this.textContent = 'Ambil Konten';
    }
});

document.getElementById('btnGenerateAi').addEventListener('click', async function () {
    const topic = document.getElementById('aiTopic').value.trim();
    const context = document.getElementById('aiContext').value.trim();
    const categoryId = document.querySelector('[name=category_id]').value;
    if (!topic) return;
    if (!categoryId) { alert('Pilih kategori dulu di form Detail Artikel di bawah.'); return; }
    this.disabled = true; this.textContent = 'Generating...';
    try {
        const res = await fetch('{{ route('admin.articles.generate-ai') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': window.csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ topic, context, category_id: categoryId })
        });
        const json = await res.json();
        if (!json.ok) throw new Error(json.message || 'Gagal generate');
        const d = json.data;
        document.querySelector('[name=title]').value = d.title || '';
        document.querySelector('[name=excerpt]').value = d.excerpt || '';
        document.querySelector('[name=body]').value = d.body || '';
        const notice = document.getElementById('aiNotice');
        notice.style.display = 'block';
        notice.textContent = d.notice;
        document.querySelector('[name=status]').value = 'draft';
    } catch (e) {
        alert(e.message);
    } finally {
        this.disabled = false; this.textContent = 'Generate Draf';
    }
});
</script>
@endpush
