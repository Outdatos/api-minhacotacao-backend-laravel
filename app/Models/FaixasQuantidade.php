<?php

namespace App\Models;

use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;

class FaixasQuantidade extends Model
{
    //
    protected $table = 'faixas_quantidade';

    protected $fillable = [ 'min_qtd', 'max_qtd', 'empresa_id' ];

    public function productPrices()
    {
     return $this->hasMany(ProductPrice::class, 'faixa_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
