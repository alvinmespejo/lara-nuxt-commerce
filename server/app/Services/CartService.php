<?php

namespace App\Services;

use App\Dto\Api\v1\CartDto;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CartService
{
    private bool $changed = false;
    private ?ShippingMethod $shipping = null;

    public function __construct(protected User $user)
    {
    }

    public function sync()
    {
        $this->user->cart->each(function ($product) {
            $quantity = $product->minStock($product->pivot->quantity);
            if ($quantity !== $product->pivot->quantity) {
                $this->changed = true;
            }

            $product->pivot->update([
                'quantity' => $quantity,
            ]);
        });
    }

    public function retreive()
    {
        $this->user->load([
            'cart.product',
            'cart.product.variations.stock',
            'cart.stock',
            'cart.type',
        ]);

        return $this->user;
    }

    public function hasChange(): bool
    {
        return $this->changed;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function empty()
    {
        $this->user->cart->detach();
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isEmpty(): bool
    {
        return $this->user->cart->sum('pivot.quantity') <= 0;
    }

    /**
     * Undocumented function
     *
     * @return MoneyService
     */
    public function subTotal(): MoneyService
    {
        $subTotal = $this->user->cart->sum(function ($product) {
            return $product->price->amount() * $product->pivot->quantity;
        });

        return new MoneyService($subTotal);
    }

    /**
     * Undocumented function
     *
     * @return MoneyService
     */
    public function total(): MoneyService
    {
        if ($this->shipping) {
            return $this->subTotal()->add($this->shipping->price);
        }

        return $this->subTotal();
    }

    /**
     * Undocumented function
     *
     * @param string|null $shippingId
     * @return self
     */
    public function withShipping(?string $shippingId): self
    {
        if (!is_null($shippingId)) {
            $this->shipping = ShippingMethod::find($shippingId);
        }

        return $this;
    }

    public function products()
    {
        return $this->user->cart;
    }

    /**
     * Undocumented function
     *
     * @param array $products
     * @return void
     */
    public function add(array $products): void
    {
        $this->user->cart()->syncWithoutDetaching(
            $this->getStorePayload($products)
        );
    }

    public function destroy(string $productId)
    {
        $this->user->cart()->detach($productId);
    }

    /**
     * Undocumented function
     *
     * @param string|integer $productId
     * @param integer $quantity
     * @return void
     */
    public function update(string|int $productId, int $quantity): void
    {
        $this->user->cart()->updateExistingPivot($productId, [
            'quantity' => $quantity
        ]);
    }

    /**
     * Undocumented function
     *
     * @param array $products
     * @return void
     */
    private function getStorePayload(array $products)
    {
        return collect($products)->keyBy('id')->map(function ($product) {
            return [
                'quantity' => (int) $product['quantity'] + $this->getCurrentQuantity($product['id'])
            ];
        });
    }

    /**
     * Undocumented function
     *
     * @param string $productId
     * @return integer
     */
    public function getCurrentQuantity(string $productId): int
    {
        $productId = trim($productId);
        if (empty($productId)) {
            return 0;
        }

        if ($product = $this->user->cart->where('id', $productId)->first()) {
            return (int) $product->pivot->quantity;
        }

        return 0;
    }
}
