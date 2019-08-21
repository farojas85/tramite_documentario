<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $fillable = ['descripcion'];

    public function requisitos()
    {
        return $this->hasMany(Requisito::class);
    }
}
