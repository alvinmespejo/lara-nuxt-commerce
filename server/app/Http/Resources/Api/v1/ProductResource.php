<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ProductResource extends JsonResource
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
            'description' => $this->description,
            'slug' => $this->slug,
            'price' => $this->formattedPrice,
            'in_stock' => $this->inStock(),
            'stock_count' => $this->stockCount(),
        ];
        return array_merge(
            $product,
            [
                'variations' => ProductVariationResource::collection(
                    $this->variations->groupBy('type.name')
                )
            ]
        );

    }
}
