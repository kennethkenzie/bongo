<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name','slug','image','icon','groups','featured','parent_id','sort_order','is_active'];

    protected $casts = ['groups' => 'array', 'featured' => 'array', 'is_active' => 'boolean'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order')->orderBy('name');
    }

    public function megaMenuGroups(): array
    {
        $this->loadMissing('children.children');

        if ($this->children->isNotEmpty()) {
            return $this->children
                ->where('is_active', true)
                ->map(fn (Category $group) => [
                    'title' => $group->name,
                    'links' => $group->children
                        ->where('is_active', true)
                        ->pluck('name')
                        ->values()
                        ->all(),
                ])
                ->values()
                ->all();
        }

        return $this->groups ?? [];
    }

    public function storefrontPayload(): array
    {
        return array_merge($this->toArray(), [
            'groups' => $this->megaMenuGroups(),
            'featured' => $this->featured ?? [],
        ]);
    }
}
