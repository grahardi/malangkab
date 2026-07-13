@extends('admin.layouts.app')

@section('title', 'Kategori Baru')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            @include('admin.categories._form', ['category' => null, 'selectedParentId' => $selectedParentId ?? null])
            <button class="btn btn-malang">Simpan Kategori</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
