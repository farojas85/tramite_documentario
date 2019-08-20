<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $fillable = ['nombre_distrito','ubigeo_id','provincia_id'];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
}
