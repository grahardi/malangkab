<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        // Hanya ambil root, anak-anaknya di-load rekursif untuk render tree.
        $tree = Category::roots()->orderBy('order')->with('childrenRecursive')->get();

        return view('admin.categories.index', compact('tree'));
    }

    public function create(Request $request): View
    {
        $categories = Category::orderBy('parent_id')->orderBy('order')->get();
        $selectedParentId = $request->integer('parent_id') ?: null;

        return view('admin.categories.create', compact('categories', 'selectedParentId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('status', 'Kategori "'.$data['name'].'" berhasil dibuat.');
    }

    public function edit(Category $category): View
    {
        $categories = Category::where('id', '!=', $category->id)->orderBy('parent_id')->orderBy('order')->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validated($request, $category->id);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        if ((int) $data['parent_id'] === $category->id) {
            return back()->withErrors(['parent_id' => 'Kategori tidak boleh menjadi induk dari dirinya sendiri.']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'Kategori "'.$data['name'].'" berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->children()->exists()) {
            return back()->withErrors(['category' => 'Hapus atau pindahkan dulu sub-kategori di bawahnya sebelum menghapus kategori ini.']);
        }

        if ($category->articles()->exists()) {
            return back()->withErrors(['category' => 'Kategori ini masih memiliki artikel. Pindahkan artikelnya terlebih dahulu.']);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berhasil dihapus.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'parent_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:170', 'alpha_dash', 'unique:categories,slug'.($ignoreId ? ",{$ignoreId}" : '')],
            'description' => ['nullable', 'string', 'max:500'],
            'icon' => ['nullable', 'string', 'max:10'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
