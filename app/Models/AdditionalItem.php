<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;

class AdditionalItem extends Model
{
    //
    protected $fillable = [ 'descricao', 'price', 'empresa_id' ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
}
