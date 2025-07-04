<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\FaixasQuantidade;
use App\Models\ProductPrice;


class Empresa extends Model
{
    //
    protected $fillable = ['name', 'email', 'cnpj', 'phone_number'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function faixas()
    {
        return $this->hasMany(FaixasQuantidade::class);
    }

    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class);
    }
    
}
