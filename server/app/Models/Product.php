<?php

namespace App\Models;

use App\Traits\CanBeScoped;
use App\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use CanBeScoped;
    use HasPrice;

    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function inStock(): bool
    {
        return $this->stockCount() > 0;
    }

    public function stockCount(): int
    {
        return $this->variations->sum(function ($variation) {
            return $this->stockCount();
        });
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class)->orderBy('order', 'asc');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
