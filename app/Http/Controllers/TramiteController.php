<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TramiteController extends Controller
{

   
    public function index()
    {
        return view('tramite');
    }
}
