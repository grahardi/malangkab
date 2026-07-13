@extends('admin.layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Struktur Kategori</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-malang btn-sm">+ Kategori Baru</a>
    </div>
    <div class="card-body">
        <p class="text-muted small">Kategori disusun bertingkat (tree) seperti WordPress/Joomla — contoh: <strong>Pariwisata</strong> (root) &rarr; <strong>Pantai</strong>, <strong>Air Terjun</strong>, dst (anak).</p>
        <ul class="list-group category-tree">
            @forelse($tree as $node)
                @include('admin.categories._tree_item', ['node' => $node, 'depth' => 0])
            @empty
                <li class="list-group-item text-muted">Belum ada kategori.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
