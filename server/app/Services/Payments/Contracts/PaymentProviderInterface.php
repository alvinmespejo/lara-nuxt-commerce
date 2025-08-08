<?php

namespace App\Services\Payments\Contracts;

use App\Models\User;

interface PaymentProviderInterface
{
    public function customer(User $user);
    public function createCustomer();
}
