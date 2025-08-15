<?php

namespace App\Services\Payments\Contracts;

use App\Models\PaymentMethod;
use App\Models\User;

interface PaymentProviderCustomerInterface
{
    public function charge(PaymentMethod $payment, string|int $amount);
    public function addCard(string $token);
    public function id();
}
