<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\ProductPrice;
use App\Models\Empresa;

class Product extends Model
{
    //
    protected $fillable = [ 'category_id', 'name', 'descricao'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }
}
