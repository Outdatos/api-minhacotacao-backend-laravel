<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaixaQuantidadeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'faixa' => $this->id,
            'min_qtd' => $this->min_qtd,
            'max_qtd' => $this->max_qtd,
            'productInfo' => $this->productPrices->map(function ($price) {
                return [
                    'product_id' => $price->product_id,
                    'price' => $price->price,
                ];
            })
        ];
    }
}
