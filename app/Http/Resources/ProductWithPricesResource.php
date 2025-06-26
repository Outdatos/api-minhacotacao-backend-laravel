<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductWithPricesResource extends JsonResource
{
   public function toArray(Request $request): array
    {
        return [
            'category' => $this->category->name,
            'product' => $this->name,
            'descricao' => $this->descricao,
            'faixas' => $this->prices->map(function ($price) {
                return [
                    'faixa' => $price->faixa_id,
                    'min_qtd' => $price->faixa->min_qtd,
                    'max_qtd' => $price->faixa->max_qtd,
                    'price' => $price->price,
                ];
            }),
        ];
    }
}
