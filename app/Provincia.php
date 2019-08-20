<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $fillable = ['nombre_provincia','ubigeo_id','departamento_id'];

    public function distritos()
    {
        return $this->hasMany(Distrito::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}
