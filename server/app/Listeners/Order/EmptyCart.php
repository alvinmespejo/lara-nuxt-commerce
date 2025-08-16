<?php

namespace App\Listeners\Order;

use App\Events\Order\OrderCreated;
use App\Services\CartService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmptyCart
{
    /**
     * Create the event listener.
     */
    public function __construct(protected CartService $cart)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $this->cart->empty();
    }
}
