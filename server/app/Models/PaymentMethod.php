<?php

namespace App\Models;

use App\Traits\CanBeDefault;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use CanBeDefault;

    protected $guarded = [];

    protected $casts = [
        'default' => 'boolean',
    ];
}
