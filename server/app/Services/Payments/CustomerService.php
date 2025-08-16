<?php

namespace App\Services\Payments;

use App\Exceptions\Api\v1\PaymentFailedException;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Services\Payments\Contracts\PaymentProviderCustomerInterface;
use App\Services\Payments\Contracts\PaymentProviderInterface;
use Illuminate\Support\Facades\Log;
use Stripe\Card;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Source;
use Throwable;
use Tymon\JWTAuth\Claims\Custom;

class CustomerService implements PaymentProviderCustomerInterface
{
    public function __construct(protected PaymentProviderInterface $gateway, protected Customer $customer)
    {
    }

    public function charge(PaymentMethod $payment, string|int $amount)
    {
        try {
            Charge::create([
                'currency' => 'usd',
                'amount' => $amount,
                'source' => $payment->provider_id,
                'customer' => $this->customer->id,
            ]);
        } catch (Throwable $th) {
            Log::error("CUSTOMER SERVICE PAYMENT CHARGE", [$th]);
            throw new PaymentFailedException();
        }
    }


    public function addCard(string $token)
    {
        $card = Customer::createSource($this->customer->id, ['source' => $token]);
        Customer::update(
            $this->customer->id,
            ['default_source' => $card->id]
        );


        return $this->gateway->user()?->paymentMethods()->create([
            'default' => true,
            'provider_id' => $card->id,
            'card_type' => $card->brand,
            'last_four' => $card->last4,
        ]);
    }

    public function id()
    {
        return $this->customer->id;
    }
}
