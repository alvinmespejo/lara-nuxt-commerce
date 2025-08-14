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

    /**
     * Undocumented function
     *
     * @param integer $count
     * @return integer
     */
    public function minStock(int $count = 0): int
    {
        return min($this->stockCount(), $count);
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function priceVaries(): bool
    {
        return $this->price->amount() !== $this->product->price->amount();
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function stock()
    {
        return $this->belongsToMany(
            ProductVariation::class,
            'product_variation_stock_view'
        )->withPivot([
            'stock',
            'in_stock'
        ]);
    }

    /**
     * Undocumented function
     *
     * @return HasOne
     */
    public function type(): HasOne
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    /**
     * Undocumented function
     *
     * @return integer|null
     */
    public function stockCount(): ?int
    {
        return (int) $this->stock->sum('pivot.stock');
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function inStock(): bool
    {
        return (bool) $this->stockCount() > 0;
    }
}
