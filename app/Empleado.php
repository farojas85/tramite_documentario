<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable =['user_id','persona_id','cargo_id','estado'];
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function persona()
    {
        return $this->hasOne(Persona::class);
    }
}
