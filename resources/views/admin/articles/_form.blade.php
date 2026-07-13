@php $depthOf = function ($cat) { $d = 0; $node = $cat; while ($node->parent) { $d++; $node = $node->parent; } return $d; }; @endphp

<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $article->title ?? '') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select" required>
            <option value="">— Pilih kategori —</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ (int) old('category_id', $article->category_id ?? null) === $cat->id ? 'selected' : '' }}>
                    {{ str_repeat('— ', $depthOf($cat)) }}{{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Ringkasan (excerpt)</label>
    <textarea name="excerpt" class="form-control" rows="2" maxlength="500">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
</div>

<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center mb-1">
        <label class="form-label mb-0">Isi Artikel</label>
        <button type="button" id="btnAutoParagraph" class="btn btn-sm btn-outline-secondary">
            Rapikan jadi Paragraf
        </button>
    </div>
    <textarea name="body" id="bodyEditor" class="form-control" rows="10" required>{{ old('body', $article->body ?? '') }}</textarea>
    <div class="form-text">
        Kalau isi artikel lama tampil menyambung jadi satu (dari sebelum pakai editor ini), klik
        "Rapikan jadi Paragraf" — teks akan otomatis dipecah per baris kosong jadi paragraf HTML yang benar.
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Gambar Sampul</label>
        <input type="text" name="cover_image" id="coverImageInput" class="form-control mb-2"
               value="{{ old('cover_image', $article->cover_image ?? '') }}" placeholder="https://... (atau isi otomatis lewat upload/unduh di bawah)">
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <input type="file" id="coverFileInput" accept="image/*" class="form-control form-control-sm" style="max-width:200px">
            <button type="button" id="btnCoverUpload" class="btn btn-sm btn-outline-secondary">Upload File</button>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center mt-2">
            <input type="url" id="coverUrlInput" class="form-control form-control-sm" style="max-width:260px" placeholder="https://sumber-gambar.com/foto.jpg">
            <button type="button" id="btnCoverFetch" class="btn btn-sm btn-outline-secondary">Unduh dari URL</button>
        </div>
        <div class="small text-muted mt-1" id="coverStatus"></div>
        <img src="{{ old('cover_image', $article->cover_image ?? '') }}" id="coverPreview"
             class="mt-2 rounded {{ ($article->cover_image ?? old('cover_image')) ? '' : 'd-none' }}" style="max-height:110px">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="draft" {{ old('status', $article->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ old('status', $article->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
        </select>
        <div class="alert alert-warning small mt-3 mb-0">
            Upload/unduh gambar tidak otomatis memberi hak pakai — pastikan Anda memang berhak
            memakainya (milik sendiri, lisensi bebas seperti Wikimedia Commons, atau sudah izin).
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Galeri</label>
    <textarea name="gallery_text" id="galleryTextarea" class="form-control mb-2" rows="4"
              placeholder="Satu URL gambar per baris">{{ old('gallery_text', isset($article) ? implode("\n", $article->gallery ?? []) : '') }}</textarea>

    <div class="d-flex gap-2 flex-wrap align-items-center">
        <input type="file" id="galleryFileInput" accept="image/*" multiple class="form-control form-control-sm" style="max-width:260px">
        <button type="button" id="btnGalleryUpload" class="btn btn-sm btn-outline-secondary">Upload Banyak File Sekaligus</button>
    </div>

    <div class="mt-2">
        <label class="form-label small mb-1">Atau tempel banyak URL (satu per baris), lalu unduh sekaligus:</label>
        <textarea id="galleryUrlList" class="form-control form-control-sm" rows="2" placeholder="https://.../foto1.jpg&#10;https://.../foto2.jpg"></textarea>
        <button type="button" id="btnGalleryFetch" class="btn btn-sm btn-outline-secondary mt-1">Unduh Semua URL di Atas</button>
    </div>
    <div class="small text-muted mt-1" id="galleryStatus"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#bodyEditor',
        height: 420,
        menubar: false,
        plugins: 'lists link autolink code wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | link | code',
        branding: false,
        promotion: false,
        content_style: 'body { font-family: -apple-system, Segoe UI, Roboto, sans-serif; font-size: 15px; }',
        // Konten lama yang cuma pakai Enter tanpa tag <p> (belum ter-wrap dengan benar)
        // akan otomatis dibungkus <p> oleh TinyMCE begitu dibuka & disimpan ulang di sini.
    });
</script>

<script>
(function () {
    const csrf = window.csrfToken;

    async function uploadFiles(files) {
        const fd = new FormData();
        [...files].forEach(f => fd.append('files[]', f));
        const res = await fetch('{{ route('admin.media.upload') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: fd,
        });
        return res.json();
    }

    async function fetchUrls(urlsText) {
        const res = await fetch('{{ route('admin.media.fetch-urls') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({ urls: urlsText }),
        });
        return res.json();
    }

    document.getElementById('btnAutoParagraph').addEventListener('click', function () {
        const editor = window.tinymce && tinymce.get('bodyEditor');
        const current = editor ? editor.getContent({ format: 'text' }) : document.getElementById('bodyEditor').value;

        const paragraphs = current
            .split(/\n{1,}/)
            .map(p => p.trim())
            .filter(Boolean)
            .map(p => `<p>${p}</p>`)
            .join('\n');

        if (editor) { editor.setContent(paragraphs); }
        else { document.getElementById('bodyEditor').value = paragraphs; }
    });

    const coverImageInput = document.getElementById('coverImageInput');
    const coverPreview = document.getElementById('coverPreview');
    const coverStatus = document.getElementById('coverStatus');

    function setCover(url) {
        coverImageInput.value = url;
        coverPreview.src = url;
        coverPreview.classList.remove('d-none');
    }

    document.getElementById('btnCoverUpload').addEventListener('click', async function () {
        const input = document.getElementById('coverFileInput');
        if (!input.files.length) return;
        this.disabled = true; coverStatus.textContent = 'Mengunggah...';
        try {
            const json = await uploadFiles(input.files);
            if (json.ok && json.urls[0]) { setCover(json.urls[0]); coverStatus.textContent = 'Berhasil diunggah.'; }
            else { coverStatus.textContent = 'Gagal mengunggah.'; }
        } catch (e) { coverStatus.textContent = 'Error: ' + e.message; }
        finally { this.disabled = false; }
    });

    document.getElementById('btnCoverFetch').addEventListener('click', async function () {
        const input = document.getElementById('coverUrlInput');
        if (!input.value.trim()) return;
        this.disabled = true; coverStatus.textContent = 'Mengunduh...';
        try {
            const json = await fetchUrls(input.value.trim());
            if (json.urls && json.urls[0]) { setCover(json.urls[0]); coverStatus.textContent = 'Berhasil diunduh & disimpan lokal.'; }
            else { coverStatus.textContent = 'Gagal: ' + (json.errors && json.errors[0] ? json.errors[0] : 'tidak diketahui'); }
        } catch (e) { coverStatus.textContent = 'Error: ' + e.message; }
        finally { this.disabled = false; }
    });

    const galleryTextarea = document.getElementById('galleryTextarea');
    const galleryStatus = document.getElementById('galleryStatus');

    function appendGallery(urls) {
        const current = galleryTextarea.value.split('\n').map(s => s.trim()).filter(Boolean);
        galleryTextarea.value = current.concat(urls).join('\n');
    }

    document.getElementById('btnGalleryUpload').addEventListener('click', async function () {
        const input = document.getElementById('galleryFileInput');
        if (!input.files.length) return;
        this.disabled = true; galleryStatus.textContent = 'Mengunggah...';
        try {
            const json = await uploadFiles(input.files);
            if (json.ok) { appendGallery(json.urls); galleryStatus.textContent = json.urls.length + ' file berhasil diunggah.'; }
        } catch (e) { galleryStatus.textContent = 'Error: ' + e.message; }
        finally { this.disabled = false; }
    });

    document.getElementById('btnGalleryFetch').addEventListener('click', async function () {
        const input = document.getElementById('galleryUrlList');
        if (!input.value.trim()) return;
        this.disabled = true; galleryStatus.textContent = 'Mengunduh...';
        try {
            const json = await fetchUrls(input.value.trim());
            appendGallery(json.urls || []);
            const errCount = (json.errors || []).length;
            galleryStatus.textContent = (json.urls || []).length + ' berhasil' + (errCount ? ', ' + errCount + ' gagal (lihat console).' : '.');
            if (errCount) console.warn('Gagal unduh galeri:', json.errors);
        } catch (e) { galleryStatus.textContent = 'Error: ' + e.message; }
        finally { this.disabled = false; }
    });
})();
</script>
