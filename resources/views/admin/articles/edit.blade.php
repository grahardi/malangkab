@extends('admin.layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title mb-0">Edit: {{ $article->title }}</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.articles.update', $article) }}">
            @csrf @method('PUT')
            @include('admin.articles._form', ['article' => $article])
            <button class="btn btn-malang">Simpan Perubahan</button>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
