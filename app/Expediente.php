<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    public function documento()
    {
        return $this->hasOne(Documento::class);
    }
}
