<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable =['nombre_departamento','ubigeo_id'];

    public function provincias()
    {
        return $this->hasManyThrough(
            Provincia::class,Distrito::class
            /*,'distrito_id','provincia_id','id','id'*/
        );
    }
}
