<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    protected $fillable = ['descripcion'];
    
    public function movimientos()
    {
        return $this->hasMany(Movimientos::class);
    }
}
