<?php

namespace App\Listeners\Order;

use App\Enums\OrderStatus;
use App\Events\Order\OrderPaymentFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkOrderPaymentFailed
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPaymentFailed $event): void
    {
        $event
            ->order
            ->update([
                'status' => OrderStatus::PAYMENT_FAILED
            ]);
    }
}
