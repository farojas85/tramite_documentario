<?php

namespace App\Http\Controllers\API;

use App\Ruta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RutaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ruta::with('procedimiento')->latest()->paginate(5);
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
            'oficina_origen' => 'required|string|max:191',
            'oficina_destino' => 'required|string|max:191',
            'orden' => 'required|numeric',
            'procedimiento_id' => 'required'
        ]);

        //Insertar
        $ruta = Ruta::create([
            'oficina_origen' => $request->oficina_origen,
            'oficina_destino' => $request->oficina_destino,
            'orden' => $request->orden,
            'procedimiento_id' => $request->procedimiento_id
        ]);

        return $ruta;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Ruta::where('id','=',$id)->first();
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
        $ruta = Ruta::where('id','=',$id)->first();

        //Validamos datos a Modificar
        $this->validate($request, [
            'oficina_origen' => 'required|string|max:191',
            'oficina_destino' => 'required|string|max:191',
            'orden' => 'required|numeric',
            'procedimiento_id' => 'required'
        ]);

        //Actualizamos datos del modelo Seleccionada
        $ruta->oficina_origen = $request->oficina_origen;
        $ruta->oficina_destino = $request->oficina_destino;
        $ruta->orden = $request->orden;
        $ruta->procedimiento_id = $request->procedimiento_id;
        $ruta->save();
            
        //Mensaje de Satisfactorio
        return $ruta;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ruta = Ruta::where('id','=',$id)->first();
        $ruta->delete();

        return $ruta;
    }
}
