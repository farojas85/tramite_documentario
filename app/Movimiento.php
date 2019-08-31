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

    public function MovimientoInternos()
    {
        return $this->hasMany(MovimientoInterno::class);
    }

    public function expediente()
    {
        return $this->belongsTo(Expediente::class);
    }

    public function TipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class);
    }
}
