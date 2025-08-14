<?php

namespace App\Models;

use App\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasPrice;

    protected $guarded = [];

    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }
}
