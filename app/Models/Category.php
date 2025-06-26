<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Empresa;

class Category extends Model
{
    // 
    protected $fillable = ['name', 'empresa_id'];
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
