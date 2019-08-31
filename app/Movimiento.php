<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    public function motivos()
    {
        return $this->belongsToMany(Motivo::class)->withTimestamps();
    }
    
    public function solicitantes()
    {
        return $this->belongsToMany(Solicitante::class)->withTimestamps();
    }
}
