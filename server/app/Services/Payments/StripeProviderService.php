<?php

namespace App\Services\Payments;

use App\Models\User;
use App\Services\Payments\Contracts\PaymentProviderInterface;

class StripeProviderService implements PaymentProviderInterface
{
    private ?User $user = null;

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
        if ($this->user->stripe_id) {
            return $this->getCustomer();
        }
    }

    protected function getCustomer()
    {

    }

    protected function create
}
