<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Dependencia;

class DependenciaController extends Controller
{
    public function index()
    {
        return Dependencia::with('UnidadOrganica:id,nombre')->latest()->paginate(5);
    }

    public function store(Request $request)
    {
        //Validamos
        $this->validate($request, [
            'nombre'      => 'required|string|max:191',
            'siglas'     => 'required|string|max:191',
            'unidad_organica_id' => 'required'
        ]);
        //Insertamos la nueva Dependencia 
        $dependencia = Dependencia::create([
            'nombre' => $request->nombre,
            'siglas' => $request->siglas,
            'unidad_organica_id' => $request->unidad_organica_id
        ]);

        return $dependencia;
    }

    public function show($id)
    {
        return Dependencia::where('id','=',$id)->first();
    }

    public function update(Request $request, $id)
    {
        //obtenemos Dependencia a Actualizar
        $dependencia = dependencia::where('id','=',$id)->first();

         //Validamos datos a Modificar
        $this->validate($request, [
            'nombre'      => 'required|string|max:191',
            'siglas'     => 'required|string|max:191',
            'unidad_organica_id' => 'required'
        ]);
      
        //Actualizamos datos de la Dependencia Seleccionada
        $dependencia->nombre = $request->nombre;
        $dependencia->siglas = $request->siglas;
        $dependencia->unidad_organica_id = $request->unidad_organica_id;
        $dependencia->save();
            
        //Mensaje de Satisfactorio
        return $dependencia;
    }

    public function destroy($id)
    {
        $dependencia = Dependencia::where('id','=',$id)->first();
        $dependencia->delete();

        return $dependencia;
    }

    public function lista()
    {
        return Dependencia::select('id','nombre')->get();
    }

    public function listaMovimiento()
    {
        return Dependencia::whereNotIn('id',[30])->select('id','nombre')->get();
    }
    public function depedencias(Request $request) {
        return Dependencia::Where('unidad_organica_id','=',$request->id)
                    ->select('id','nombre')->get();
    }
}
