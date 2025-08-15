<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\v1\PaymentMethodStoreRequest;
use App\Http\Resources\Api\v1\PaymentMethodResource;
use App\Http\Response\ApiResponse;
use App\Http\Response\ApiResponseError;
use App\Models\PaymentMethod;
use App\Services\Payments\StripeProviderService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PaymentMethodController extends Controller
{
    public function __construct(protected StripeProviderService $service)
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            return new ApiResponse(
                PaymentMethodResource::collection(
                    $request->user()->paymentMethods
                )
            );
        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentMethodStoreRequest $request)
    {
        $user = $request->user();
        try {
            $card = $this->service->withCustomer($user)
                    ->createCustomer()
                    ->addCard($request->token);

            return new ApiResponse(
                new PaymentMethodResource($card),
                code: Response::HTTP_CREATED
            );

        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, PaymentMethod $paymentMethod)
    {
        try {
            $paymentMethod->delete();
            return new ApiResponse(code: Response::HTTP_NO_CONTENT);
        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }
}
