<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\CartStoreRequest;
use App\Http\Requests\Api\v1\CartUpdateRequest;
use App\Http\Resources\Api\v1\CartResource;
use App\Http\Response\ApiResponse;
use App\Http\Response\ApiResponseError;
use App\Models\ProductVariation;
use App\Services\CartService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CartController extends Controller
{
    public function __construct(protected CartService $cart)
    {
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return JsonResource|Responsable
     */
    public function index(Request $request): JsonResource|Responsable
    {
        try {
            $this->cart->sync();
            return (new CartResource($this->cart->retreive()))
                    ->additional([
                        'meta' => $this->meta($request->shipping_method_id ?? null)
                    ]);

        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }

    /**
     * Undocumented function
     *
     * @param string|null $shippingMethodId
     * @return array
     */
    private function meta(?string $shippingMethodId): array
    {
        return [
            'total' => $this->cart->withShipping($shippingMethodId)->total()->formatted(),
            'subtotal' => $this->cart->subTotal()->formatted(),
            'changed' => $this->cart->hasChange(),
            'empty' => $this->cart->isEmpty(),
        ];
    }

    /**
     * Undocumented function
     *
     * @param CartStoreRequest $request
     * @return void
     */
    public function store(CartStoreRequest $request): Responsable
    {
        try {
            $this->cart->add($request->products);
            return new ApiResponse(code: Response::HTTP_CREATED);
        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }

    public function update(CartUpdateRequest $request, ProductVariation $productVariation)
    {
        try {
            $this->cart->update($productVariation->id, $request->quantity);
            return new ApiResponse();
        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }

    public function destroy(ProductVariation $productVariation)
    {
        try {
            $this->cart->destroy($productVariation->id);
            return new ApiResponse();
        } catch (Throwable $th) {
            return new ApiResponseError($th);
        }
    }
}
