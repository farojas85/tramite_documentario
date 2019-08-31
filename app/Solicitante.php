<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
    protected $fillable = ['persona_id','estado','eliminado'];
    
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function movimientos()
    {
        return $this->belongsToMany(Movimiento::class)->withTimestamps();
    }
}
