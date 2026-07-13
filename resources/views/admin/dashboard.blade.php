@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner"><h3>{{ $stats['articles'] }}</h3><p>Total Artikel</p></div>
            <i class="small-box-icon bi bi-file-earmark-text"></i>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner"><h3>{{ $stats['published'] }}</h3><p>Published</p></div>
            <i class="small-box-icon bi bi-check-circle"></i>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner"><h3>{{ $stats['drafts'] }}</h3><p>Draft</p></div>
            <i class="small-box-icon bi bi-pencil-square"></i>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box text-bg-secondary">
            <div class="inner"><h3>{{ $stats['categories'] }}</h3><p>Kategori</p></div>
            <i class="small-box-icon bi bi-diagram-3"></i>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Artikel Terbaru</h3>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-malang btn-sm">+ Artikel Baru</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Diperbarui</th><th></th></tr></thead>
            <tbody>
                @forelse($latest as $article)
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
                    <td>{{ $article->updated_at->diffForHumans() }}</td>
                    <td><a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-outline-secondary">Edit</a></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada artikel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
