<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Departamento;
use App\Provincia;
use App\Distrito;

class UbigeoController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function procesar(Request $request) 
    {
        //Agregamos Departamento
        $ubigeo_id = Str::substr($request->ubigeo,0,2);        
        $departamento = Departamento::where('ubigeo_id','=',$ubigeo_id)->first();
        $departamento_count = Departamento::where('ubigeo_id','=',$ubigeo_id)->count();
       
        $mensaje="";
        if($departamento_count == 0) {
            $departamento = Departamento::Create([
                'ubigeo_id' => $ubigeo_id,
                'nombre_departamento' => $request->departamento
            ]);
            $mensaje.="<spam class='text-blue'>¡ Departamento Agregrado !</spam><br>";
        }
        else{
            $mensaje.="<spam class='text-red'>¡ Departamento Ya Existe !</spam><br>";
        }
        
        //Agregamos Provincia
        $ubigeo_id = Str::substr($request->ubigeo,0,4);
        $provincia = Provincia::where('ubigeo_id','=',$ubigeo_id)->first();
        $provincia_count = Provincia::where('ubigeo_id','=',$ubigeo_id)->count();
        
        if($provincia_count == 0) {
            $provincia = Provincia::Create([
                'ubigeo_id' => $ubigeo_id,
                'nombre_provincia' => $request->provincia,
                'departamento_id' => $departamento->id
            ]);
            $mensaje.="<spam class='text-success'>¡ Provincia Agregrada !</spam><br>";
        }
        else {
            $mensaje.="<spam class='text-red'>¡ Provincia Ya Existe !</spam><br>";
        }

        //Agregamos Distrito
        $distrito = Distrito::where('ubigeo_id','=',$request->ubigeo)->first();
        $distrito_count = Distrito::where('ubigeo_id','=',$request->ubigeo)->count();

        if($distrito_count == 0) {
            $distrito = Distrito::Create([
                'ubigeo_id' => $request->ubigeo,
                'nombre_distrito' => $request->distrito,
                'provincia_id' => $provincia->id
            ]);
            $mensaje.="<spam class='text-orange'>¡ Distrito Agregado !</spam><br>";
        } else {
            $mensaje.="<spam class='text-red'>¡ Distrito Ya Existe !</spam><br>";
        }

        return $mensaje;
    }
}
