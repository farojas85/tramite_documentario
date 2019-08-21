<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $fillable = ['oficina_origen','oficina_destino',
                            'orden','procedimiento_id'];
    
    public function procedimiento()
    {
        return $this->belongsTo(Procedimiento::class);
    }
}
