<?php

namespace App\Services\Payments;

use App\Models\User;
use App\Services\Payments\Contracts\PaymentProviderInterface;
use Stripe\Customer;

class StripeProviderService implements PaymentProviderInterface
{
    protected ?User $user = null;

    public function withCustomer(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function createCustomer()
    {
        if ($this->user->provider_id) {
            return $this->getCustomer();
        }

        $customer = new CustomerService(
            $this,
            $this->createStripeCustomer()
        );

        $this->user->update([
            'provider_id' => $customer->id()
        ]);

        return $customer;
    }

    public function getCustomer()
    {
        return new CustomerService(
            $this,
            Customer::retrieve($this->user->provider_id)
        );
    }

    protected function createStripeCustomer()
    {
        return Customer::create([
            'name' => $this->user->name,
            'email' => $this->user->email
        ]);
    }
}
