<?php

namespace App\Http\Controllers\API;

use App\Procedimiento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProcedimientoController extends Controller
{

    public function index()
    {
        return Procedimiento::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        //Validación
        $this->validate($request, [
            'denominacion'      => 'required|string|max:191'
        ]);

        //Insertar
        $procedimiento = Procedimiento::create([
            'denominacion' => $request->denominacion
        ]);

        return $procedimiento;
    }

    public function show($id)
    {
        return Procedimiento::where('id','=',$id)->first();
    }

    public function update(Request $request, $id)
    {
         //obtenemos Unidad a Actualizar
         $procedimiento = Procedimiento::where('id','=',$id)->first();

         //Validamos datos a Modificar
        $this->validate($request, [
            'denominacion'      => 'required|string|max:191'
        ]);
      
        //Actualizamos datos del modelo Seleccionada
        $procedimiento->denominacion = $request->denominacion;
        $procedimiento->save();
            
        //Mensaje de Satisfactorio
        return $procedimiento;
    }

    public function destroy($id)
    {
        $procedimiento = Procedimiento::where('id','=',$id)->first();
        $procedimiento->delete();

        return $procedimiento;
    }

    public function lista(){
        return Procedimiento::select('id','denominacion')->get();
    }
}
