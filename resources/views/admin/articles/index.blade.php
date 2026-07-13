@extends('admin.layouts.app')

@section('title', 'Manajemen Artikel')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->pathLabel() }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            </select>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul..." class="form-control form-control-sm">
            <button class="btn btn-sm btn-outline-secondary">Cari</button>
        </form>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.articles.publish-drafts') }}" method="POST"
                  onsubmit="return confirm('Publish semua artikel berstatus Draft sesuai filter yang sedang aktif (kategori/pencarian)?')">
                @csrf
                <input type="hidden" name="category" value="{{ request('category') }}">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <button class="btn btn-outline-success btn-sm">
                    <i class="bi bi-check2-circle"></i> Publish Semua Draft (sesuai filter)
                </button>
            </form>
            <a href="{{ route('admin.articles.create') }}" class="btn btn-malang btn-sm">+ Artikel Baru</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Dilihat</th><th>Diperbarui</th><th></th></tr></thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td><span class="badge text-bg-secondary">{{ $article->category->pathLabel() }}</span></td>
                    <td>
                        @if($article->status === 'published')
                            <span class="badge text-bg-success">Published</span>
                        @else
                            <span class="badge text-bg-warning">Draft</span>
                        @endif
                    </td>
                    <td>{{ $article->views }}</td>
                    <td>{{ $article->updated_at->diffForHumans() }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus artikel ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada artikel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $articles->links('pagination::bootstrap-five') }}</div>
</div>
@endsection
