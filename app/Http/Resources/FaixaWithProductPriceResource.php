<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaixaWithProductPriceResource extends JsonResource
{
      public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'product_id' => $this->product_id,
            'faixa_id'   => $this->faixa_id,
            'price'      => $this->price,
        ];
    }
}
