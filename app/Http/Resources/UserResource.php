<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            // 'address' => $this->address,
            // 'city' => $this->city,
            // 'zip_code' => $this->zip_code,
            // 'country' => $this->country,
            'phone_number' => $this->phone_number,
            // 'profile_image' => $this->profile_image,
            // 'profile_completed' => $this->profile_completed,
            'role' => $this->role,
            'empresa_id' => $this->empresa_id,
            'empresa' => new EmpresaResource($this->whenLoaded('empresa')), // Aqui você inclui a empresa
        ];
    }
}
