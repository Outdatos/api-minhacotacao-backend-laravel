<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithProductsResource extends JsonResource
{
   public function toArray(Request $request): array
    {
        return [
            'categoria' => $this->name,
            'products' => ProductResource::collection($this->products),
        ];
    }
}
