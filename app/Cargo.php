<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillable=['nombre_cargo','dependencia_id','cargo_calificado_id',
                        'nominativo_interno'];

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function CargoCalificado()
    {
        return $this->belongsTo(CargoCalificado::class);
    }
}
