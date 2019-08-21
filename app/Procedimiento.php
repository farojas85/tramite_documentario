<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedimiento extends Model
{
    protected $fillable =['denominacion'];

    public function rutas()
    {
        return $this->hasMany(Ruta::class);
    }
}
