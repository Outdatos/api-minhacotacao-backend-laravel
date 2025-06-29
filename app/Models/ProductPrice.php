<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\FaixasQuantidade;

class ProductPrice extends Model
{
    //
    protected $fillable = ['product_id', 'faixa_id', 'price'];

    protected $casts = [
    'price' => 'decimal:2',
    ];

   // Accessor para retornar o preço como string, se necessário
   public function getPriceStringAttribute()
   {
       if ($this->price === null) {
           return ''; // 
       }
       return number_format($this->price, 2, ',', '.');
   }

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

     public function faixa()
    {
        return $this->belongsTo(FaixasQuantidade::class, 'faixa_id');
    }
}
