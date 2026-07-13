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
    <label class="form-label">Isi Artikel (HTML diperbolehkan, mis. &lt;p&gt;...&lt;/p&gt;)</label>
    <textarea name="body" class="form-control" rows="10" required>{{ old('body', $article->body ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">URL Gambar Sampul</label>
        <input type="text" name="cover_image" class="form-control" value="{{ old('cover_image', $article->cover_image ?? '') }}" placeholder="https://...">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="draft" {{ old('status', $article->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ old('status', $article->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
        </select>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Galeri (satu URL gambar per baris)</label>
    <textarea name="gallery_text" class="form-control" rows="3">{{ old('gallery_text', isset($article) ? implode("\n", $article->gallery ?? []) : '') }}</textarea>
</div>
