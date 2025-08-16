<?php

namespace App\Listeners\Order;

use App\Enums\OrderStatus;
use App\Events\Order\OrderPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkOrderProcessing
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
    public function handle(OrderPaid $event): void
    {
        $event->order->update([
            'status' => OrderStatus::PROCESSING
        ]);
    }
}
