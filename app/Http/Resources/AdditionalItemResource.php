<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdditionalItemResource extends JsonResource
{
   public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'descricao' => $this->descricao,
            'price'     => $this->price,
            'cliche_price'     => $this->is_cliche_price,
        ];
    }
}
