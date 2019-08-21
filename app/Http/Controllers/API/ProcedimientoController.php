<?php

namespace App\Http\Controllers\API;

use App\Procedimiento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProcedimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Procedimiento::latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Procedimiento::where('id','=',$id)->first();
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
