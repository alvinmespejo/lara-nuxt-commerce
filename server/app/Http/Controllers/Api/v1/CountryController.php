<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\CountryResource;
use App\Http\Response\ApiResponse;
use App\Http\Response\ApiResponseError;
use App\Models\Country;
use Illuminate\Http\Request;
use Throwable;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return new ApiResponse(
                CountryResource::collection(
                    Country::query()->get()
                )
            );
        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }
}
