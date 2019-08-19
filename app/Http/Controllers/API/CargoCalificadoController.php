<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CargoCalificado;

class CargoCalificadoController extends Controller
{

    public function index()
    {
        return CargoCalificado::latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validamos
        $this->validate($request, [
            'nombre'      => 'required|string|max:191',
            'abreviatura' => 'required|string|max:191'
        ]);
        //Insertamos
        $cargocalificado = CargoCalificado::create([
            'nombre' => $request->nombre,
            'abreviatura' => $request->abreviatura
        ]);

        return $cargocalificado;
    }

    public function show($id)
    {
        return CargoCalificado::where('id','=',$id)->first();
    }

    public function update(Request $request, $id)
    {
        //obtenemos Datos a Actualizar
        $cargocalificado = CargoCalificado::where('id','=',$id)->first();

         //Validamos datos a Modificar
        $this->validate($request, [
            'nombre'      => 'required|string|max:191',
            'abreviatura' => 'required|string|max:191'
        ]);
      
        //Actualizamos Datos
        $cargocalificado->nombre = $request->nombre;
        $cargocalificado->abreviatura = $request->abreviatura;
        $cargocalificado->save();
            
        //Mensaje de Satisfactorio
        return $cargocalificado;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cargocalificado = CargoCalificado::where('id','=',$id)->first();
        $cargocalificado->delete();

        return   $cargocalificado;
    }

    public function lista()
    {
        return CargoCalificado::select('id','nombre','abreviatura')->get();
    }
}
