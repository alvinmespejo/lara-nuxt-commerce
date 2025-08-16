<?php

namespace App\Listeners\Order;

use App\Events\Order\OrderCreated;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderPaymentFailed;
use App\Services\Payments\Contracts\PaymentProviderInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessPayment implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct(protected PaymentProviderInterface $gateway)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        try {
            $this->gateway->withCustomer($order->user)
            ->getCustomer()
            ->charge(
                $order->paymentMethod,
                $order->total()->amount()
            );

            OrderPaid::dispatch($order);
        } catch (Throwable $th) {
            Log::error('FAILED CHARGINGG CUSTOMER', [$order, $th]);
            OrderPaymentFailed::dispatch($order);
        }
    }
}
