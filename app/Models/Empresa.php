<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    //
    protected $fillable = ['name', 'email', 'cnpj', 'phone_number'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
