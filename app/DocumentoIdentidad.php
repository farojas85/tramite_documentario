<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoIdentidad extends Model
{
    protected $fillable = ['descripcion_larga','descripcion_corta','tipo'];
    
}
