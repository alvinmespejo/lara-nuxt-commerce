<?php

namespace App\Models;

use App\Traits\CanBeDefault;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PaymentMethod extends Model
{
    use CanBeDefault;

    protected $guarded = [];

    protected $casts = [
        'default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
