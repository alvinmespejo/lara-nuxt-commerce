<?php

namespace App\Dto\Api\v1;

use App\Services\CartService;

class OrderDto
{
    public function __construct(
        public readonly CartService $cart,
        public readonly string|int $addressId,
        public readonly string|int $shippingMethodId,
        public readonly string|int $paymentMethodId,
    ) {
    }
}
