<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id', 'name', 'slug', 'description', 'icon', 'order',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function publishedArticles(): HasMany
    {
        return $this->articles()->where('status', 'published')->orderByDesc('published_at');
    }

    /** Induk kategori (null bila ini kategori root, seperti "Pariwisata"). */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /** Anak/sub-kategori langsung (mis. "Pantai" di bawah "Pariwisata"). */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order');
    }

    /** Rekursif: semua turunan (anak, cucu, dst) untuk render tree admin. */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }

    /** "Pariwisata / Pantai" — dipakai di dropdown & breadcrumb admin. */
    public function pathLabel(): string
    {
        $names = [$this->name];
        $node = $this;
        while ($node->parent) {
            $node = $node->parent;
            array_unshift($names, $node->name);
        }

        return implode(' / ', $names);
    }
}
