<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadOrganica extends Model
{
    protected $fillable = ['id','nombre','siglas'];

    public function dependecias()
    {
        return $this->hasMany(Depedencia::class);
    }
}
