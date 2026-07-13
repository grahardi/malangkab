@extends('admin.layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf @method('PUT')
            @include('admin.categories._form', ['category' => $category, 'selectedParentId' => $category->parent_id])
            <button class="btn btn-malang">Simpan Perubahan</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
