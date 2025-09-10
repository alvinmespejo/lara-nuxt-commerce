<?php

namespace App\Http\Resources\Api\v1;

use App\Services\MoneyService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->formattedPrice,
            'description' => $this->descrition,
            'stock_count' => $this->stockCount(),
            'in_stock' => $this->inStock(),
            'type' => $this->whenLoaded(
                'type',
                $this->type->name,
            ),
        ];

        return array_merge(
            $product,
            [
                'product' => new ProductResourceIndex($this->product),
                'quantity' => $this->pivot->quantity,
                'total' => $this->getTotal()->formatted()
            ]
        );
    }

    private function getTotal(): MoneyService
    {
        return new MoneyService($this->pivot->quantity * $this->price->amount());
    }
}
