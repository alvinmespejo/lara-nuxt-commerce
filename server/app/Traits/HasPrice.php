<?php

namespace App\Traits;

use App\Services\MoneyService;

trait HasPrice
{
    public function getPriceAttribute($value): MoneyService
    {
        return new MoneyService($value);
    }

    public function getFormattedPriceAttribute()
    {
        return $this->price->formatted();
    }
}
