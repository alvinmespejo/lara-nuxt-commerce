<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Services\MoneyService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => OrderStatus::class
    ];

    public static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->status = OrderStatus::PENDING;
        });
    }

    public function getSubtotalAttribute(string|int $subTotal): MoneyService
    {
        return new MoneyService($subTotal);
    }

    /**
     * Undocumented function
     *
     * @return MoneyService
     */
    public function total(): MoneyService
    {
        return $this->subtotal->add($this->shippingMethod->price);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariation::class, 'product_variation_orders')
            ->withPivot(['quantity'])
            ->withTimestamps();
    }
}
