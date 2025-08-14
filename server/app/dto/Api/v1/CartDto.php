<?php

namespace App\Dto\Api\v1;

use App\Models\User;

class CartDto
{
    public function __construct(
        public readonly User $user
    ) {

    }
}
