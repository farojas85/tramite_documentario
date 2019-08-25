<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['nombres','apellidos','razon_social','documento_identidad_id',
                            'numero_documento','correo','direccion'];
                            
    public function DocumentoIdentidad()
    {
        return $this->belongsTo(DocumentoIdentidad::class,'documento_identidad_id','id');
    }

    public function solicitante()
    {
        return $this->belongsTo(Solicitante::class);
    }
}
