<?php

namespace App\Http\Controllers\Api\v1;

use App\Dto\Api\v1\OrderDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\OrderStoreRequest;
use App\Http\Resources\Api\v1\OrderResource;
use App\Http\Response\ApiResponse;
use App\Http\Response\ApiResponseError;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Throwable;

class OrderController extends Controller implements HasMiddleware
{
    public function __construct(protected OrderService $service)
    {

    }


    public static function middleware(): array
    {
        return [
            new Middleware(
                ['cart.sync', 'cart.empty'],
                only: ['store']
            )
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        try {
            $orders = $user->orders()
                    ->with([
                        'address',
                        'products',
                        'shippingMethod',
                        'products.type',
                        'products.stock',
                        'products.product',
                        'products.product.variations',
                        'products.product.variations.stock',
                    ])
                    ->latest()
                    ->paginate(10);

            return OrderResource::collection($orders);

        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request, CartService $cart)
    {
        try {
            $dto = new OrderDto(
                $cart,
                $request->address_id,
                $request->shipping_method_id,
                $request->payment_method_id
            );

            return new ApiResponse(
                new OrderResource(
                    $this->service->store($dto)
                )
            );

        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }
}
