<?php

namespace App\Services\Payments\Contracts;

use App\Models\User;

interface PaymentProviderInterface
{
    public function withCustomer(User $user);
    public function createCustomer();
}
