<?php

namespace App\Rules;

use App\Models\Address;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class ValidShippingMethod implements ValidationRule
{
    public function __construct(protected string $addressId)
    {

    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$address = Address::find($this->addressId)) {
            $fail('Invalid :attribute provided');
        }

        if (!$address->country->shippingMethods->contains('id', $value)) {
            $fail('Invalid :attribute provided');
        }
    }
}
