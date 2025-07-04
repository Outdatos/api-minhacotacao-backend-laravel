<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\FaixasQuantidade;
use App\Models\Empresa;

class ProductPrice extends Model
{
    //
    protected $fillable = ['product_id', 'faixa_id', 'price', 'empresa_id'];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

     public function faixa()
    {
        return $this->belongsTo(FaixasQuantidade::class, 'faixa_id');
    }

     public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
