<?php

namespace App\Models;

use App\Services\MoneyService;
use App\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductVariation extends Model
{
    use HasPrice;

    protected $guarded = [];

    public function getPriceAttribute($value)
    {
        if ($value === null) {
            return $this->product->price;
        }

        return new MoneyService($value);
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

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function stock()
    {
        return $this->belongsToMany(
            ProductVariation::class,
            'product_variation_stock_view'
        )->withPivot([
            'stock','in_stock'
        ]);
    }

    public function type(): HasOne
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    public function stockCount(): ?int
    {
        return $this->stock->sum('pivot.stock');
    }

    public function inStock(): bool
    {
        return $this->stockCount() > 0;
    }
}
