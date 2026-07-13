@php
    // Hitung kedalaman tiap kategori untuk indentasi dropdown "Induk Kategori"
    $depthOf = function ($cat) {
        $d = 0; $node = $cat;
        while ($node->parent) { $d++; $node = $node->parent; }
        return $d;
    };
@endphp

<div class="mb-3">
    <label class="form-label">Induk Kategori (kosongkan bila ini kategori root, mis. "Pariwisata")</label>
    <select name="parent_id" class="form-select">
        <option value="">— Tidak ada (jadi kategori root) —</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ (int) old('parent_id', $selectedParentId) === $cat->id ? 'selected' : '' }}>
                {{ str_repeat('— ', $depthOf($cat)) }}{{ $cat->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Nama Kategori</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Ikon (emoji, opsional)</label>
        <input type="text" name="icon" class="form-control" value="{{ old('icon', $category->icon ?? '') }}" placeholder="🏖️">
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Slug (kosongkan untuk auto dari nama)</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug ?? '') }}" placeholder="pariwisata-pantai">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Urutan tampil</label>
        <input type="number" name="order" class="form-control" value="{{ old('order', $category->order ?? 0) }}" min="0">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control" rows="2">{{ old('description', $category->description ?? '') }}</textarea>
</div>
