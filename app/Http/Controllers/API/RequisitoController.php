<?php

namespace App\Http\Controllers\API;

use App\Requisito;
use App\Procedimiento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class RequisitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Requisito::with('TipoDocumento')->latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ////Validamos
        $this->validate($request, [
            'descripcion'      => 'required|string|max:191',
            'tipo_documento_id' => 'required'
        ]);
        //Insertamos
        $requisito = Requisito::create([
            'descripcion' => $request->descripcion,
            'tipo_documento_id' => $request->tipo_documento_id
        ]);

        return $requisito;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Requisito::with('TipoDocumento')->where('id','=',$id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //obtenemos Datos a Actualizar
        $requisito = Requisito::where('id','=',$id)->first();

        //Validamos datos a Modificar
        $this->validate($request, [
            'descripcion'      => 'required|string|max:191',
            'tipo_documento_id' => 'required'
        ]);
      
        //Actualizamos Datos
        $requisito->descripcion = $request->descripcion;
        $requisito->tipo_documento_id = $request->tipo_documento_id;
        $requisito->save();
            
        //Mensaje de Satisfactorio
        return $requisito;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //obtenemos Datos a Actualizar
        $requisito = Requisito::where('id','=',$id)->first();
        $requisito->delete();

        return $requisito;
    }

    public function lista() {
        return Requisito::select('id','descripcion')->get();
    }
    
    public function requiproc_paginate() {
        return DB::table('requisito_procedimiento as rp')
                    ->join('requisitos as re','rp.requisito_id','=','re.id')
                    ->join('procedimientos as pr','rp.procedimiento_id','=','pr.id')
                ->select(
                    'rc.id','re.descripcion as requisito',
                    'pr.descripcion as procedimiento',
                    'rp.requisito_id','rp.procedimiento_id'
                )->latest()->paginate(5);
    }
}
