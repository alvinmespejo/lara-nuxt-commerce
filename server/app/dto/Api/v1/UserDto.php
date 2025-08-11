<?php

namespace App\Dto\Api\v1;

class UserDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    ) {

    }
}
