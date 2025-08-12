<?php

namespace App\Models;

use App\Services\MoneyService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariation extends Model
{
    protected $guarded = [];

    public function getPriceAttribute($value)
    {
        return is_null($value)
            ? $this->product->price
            : new MoneyService($value);
    }

    public function minStock($count): int
    {
        return min($this->stockCount(), $count);
    }

    public function priceVaries(): bool
    {
        return $this->price->amount() !== $this->product->price->amount();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function type()
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    public function stockCount(): ?int
    {
        return $this->stock()->sum('pivot.stock');
    }

    public function inStock(): bool
    {
        return $this->stockCount() > 0;
    }
}
