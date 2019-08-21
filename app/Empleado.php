<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function persona()
    {
        return $this->hasOne(Persona::class);
    }
}
