<?php

namespace App\Http\Resources\Api\v1;

use Collator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        if ($this->resource instanceof Collection) {
            return ProductVariationResource::collection($this->resource);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->formattedPrice,
            'type' => $this->type->name,
            'price_varies' => $this->priceVaries(),
            'stock_count' => (int) $this->stockCount(),
            'in_stock' => $this->inStock(),
            'product' => new ProductResourceIndex($this->product),
        ];
    }
}
