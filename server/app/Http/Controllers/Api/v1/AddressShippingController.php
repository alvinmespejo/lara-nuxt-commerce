<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\ShippingMethodResource;
use App\Http\Response\ApiResponse;
use App\Http\Response\ApiResponseError;
use App\Models\Address;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Throwable;

class AddressShippingController extends Controller
{
    use AuthorizesRequests;

    public function show(Address $address)
    {
        $this->authorize('view', $address);
        try {
            return new ApiResponse(
                ShippingMethodResource::collection(
                    $address->country->shippingMethods
                )
            );
        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }
}
