<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CargoCalificado extends Model
{
    protected $fillable = ['nombre','abreviatura'];
    
    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }
}
