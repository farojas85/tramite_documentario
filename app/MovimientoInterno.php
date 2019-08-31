<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoInterno extends Model
{
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class);
    }
}
