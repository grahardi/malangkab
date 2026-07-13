<li class="list-group-item">
    <div class="d-flex justify-content-between align-items-center" style="padding-left: {{ $depth * 24 }}px;">
        <div>
            @if($depth > 0)
                <i class="bi bi-arrow-return-right text-muted"></i>
            @endif
            <span class="me-1">{{ $node->icon }}</span>
            <strong>{{ $node->name }}</strong>
            <span class="badge badge-tree text-bg-light border">{{ $node->slug }}</span>
            <span class="badge badge-tree text-bg-secondary">{{ $node->articles()->count() }} artikel</span>
        </div>
        <div>
            <a href="{{ route('admin.categories.create', ['parent_id' => $node->id]) }}" class="btn btn-sm btn-outline-success" title="Tambah sub-kategori">
                <i class="bi bi-plus-lg"></i>
            </a>
            <a href="{{ route('admin.categories.edit', $node) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
            <form action="{{ route('admin.categories.destroy', $node) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori {{ $node->name }}?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
        </div>
    </div>

    @if($node->childrenRecursive->isNotEmpty())
        <ul class="list-group mt-2">
            @foreach($node->childrenRecursive as $child)
                @include('admin.categories._tree_item', ['node' => $child, 'depth' => $depth + 1])
            @endforeach
        </ul>
    @endif
</li>
