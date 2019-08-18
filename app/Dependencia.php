<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    protected $fillable = ['nombre','siglas','unidad_organica_id'];
    
    public function UnidadOrganica()
    {
        return $this->belongsTo(UnidadOrganica::class);
    }
}
