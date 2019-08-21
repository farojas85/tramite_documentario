<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TramiteController extends Controller
{
  
    public function index()
    {
        $usuario = null;
        if(Auth::check()){
            $usuario = User::where('id','=',Auth::user()->id)->first();
        }
        return view('tramite',compact('usuario'));
    }
}
