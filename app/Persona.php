<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    public function DocumentoIdentidad()
    {
        return $this->belongsTo(DocumentoIdentidad::class,'documento_identidad_id','id');
    }
}
