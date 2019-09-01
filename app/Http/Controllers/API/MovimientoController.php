<?php

namespace App\Http\Controllers\API;

use App\Movimiento;
use App\Motivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function motivos(Request $request) 
    {
        return Movimiento::with('motivos')->where('id','=',$request->id)->first();
    }

    public function by_expediente(Request $request){
        return Movimiento::where('expediente_id','=',$request->id)
                            ->select('expediente_id','id')
                            ->first();
    }
}
