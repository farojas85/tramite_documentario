<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cargo;

class CargoController extends Controller
{
    public function index()
    {
        return Cargo::with('dependencia:id,nombre')
                    ->with('CargoCalificado:id,nombre,abreviatura')
                    ->latest()->paginate(5);
    }

    public function store(Request $request)
    {
         //Validamos
         $this->validate($request, [
            'nombre_cargo'      => 'required|string|max:191',
            'cargo_calificado_id' => 'required',
            'dependencia_id' => 'required'
        ]);
        //Insertamos
        $cargo = Cargo::create([
            'nombre_cargo' => $request->nombre_cargo,
            'dependencia_id' => $request->dependencia_id,
            'cargo_calificado_id' => $request->cargo_calificado_id,
            'nominativo_interno' =>$request->nominativo_interno
        ]);

        return $cargo;
    }

    public function show($id)
    {
        return Cargo::where('id','=',$id)->first();
    }

    public function update(Request $request, $id)
    {
        //obtenemos Datos a Actualizar
        $cargo = Cargo::where('id','=',$id)->first();

         //Validamos datos a Modificar
        $this->validate($request, [
            'nombre_cargo'      => 'required|string|max:191',
            'dependencia_id' => 'required',
            'cargo_calificado_id' => 'required'
        ]);
      
        //Actualizamos Datos
        $cargo->nombre_cargo = $request->nombre_cargo;
        $cargo->dependencia_id = $request->dependencia_id;
        $cargo->cargo_calificado_id = $request->cargo_calificado_id;
        $cargo->nominativo_interno = $request->nominativo_interno;
        $cargo->save();
            
        //Mensaje de Satisfactorio
        return $cargo;
    }

    public function destroy($id)
    {
        $cargo = Cargo::where('id','=',$id)->first();
        $cargo->delete();

        return $cargo;
    }

    public function lista()
    {
        return Cargo::select('id','nombre_cargo')->get();
    }
}
