<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motivo extends Model
{
    protected $fillable =['motivo'];

    public function movimientos()
    {
        return $this->belongsToMany(Movimiento::class)->withTimestamps();
    }
}
