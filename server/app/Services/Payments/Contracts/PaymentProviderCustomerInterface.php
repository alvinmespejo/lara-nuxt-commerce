<?php

use App\Models\User;

interface PaymentProviderCustomerInterface
{
    public function createCustomer();
    public function withUser(User $user);
}
