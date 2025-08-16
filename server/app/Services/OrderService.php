<?php

namespace App\Services;

use App\Dto\Api\v1\OrderDto;
use App\Events\Order\OrderCreated;
use App\Models\Order;

class OrderService
{
    public function __construct(protected CartService $cart)
    {
    }


    public function store(OrderDto $order): Order
    {
        $orderResponse = $this->createOrder($order);
        $products = $order->cart->products()->keyBy('id')->map(function ($product) {
            return [
                'quantity' => $product->pivot->quantity
            ];
        })->toArray();

        $orderResponse->products()->sync($products);
        OrderCreated::dispatch($orderResponse);
        return $orderResponse;
    }

    private function createOrder(OrderDto $order): Order
    {
        return $order->cart->user->orders()->create(
            array_merge([
                'address_id' => $order->addressId,
                'shipping_method_id' => $order->shippingMethodId,
                'payment_method_id' => $order->paymentMethodId,
            ], [
                'subtotal' => $order->cart->subTotal()->amount()
            ])
        );
    }
}
