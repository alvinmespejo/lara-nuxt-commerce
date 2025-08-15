<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\AddressStoreRequest;
use App\Http\Resources\Api\v1\AddressResource;
use App\Http\Response\ApiResponse;
use App\Http\Response\ApiResponseError;
use App\Models\Address;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $user->load(['addresses.country']);
            return new ApiResponse(
                AddressResource::collection($user->addresses)
            );
        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressStoreRequest $request)
    {
        try {
            $address = Address::make(
                $request->only(
                    'name',
                    'address_1',
                    'city',
                    'postal_code',
                    'country_id',
                    'default',
                )
            );

            $request->user()->addresses()->save($address);
            return new ApiResponse(new AddressResource($address->load('country')), code: Response::HTTP_CREATED);
        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        return new ApiResponse(
            new AddressResource($address)
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();
    }
}
