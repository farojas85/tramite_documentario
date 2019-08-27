<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    public function expediente()
    {
        return $this->belongsTo(Expediente::class);
    }
}
