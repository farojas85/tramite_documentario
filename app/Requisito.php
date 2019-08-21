<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisito extends Model
{
    protected $fillable = ['descripcion','tipo_documento_id'];

    public function TipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class);
    }

    public function procedimientos()
    {
        return $this->belongsToMany(Procedimiento::class)->withTimestamps();
    }
}
