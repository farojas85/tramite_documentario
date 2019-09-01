<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UnidadOrganica;

class UnidadOrganicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UnidadOrganica::latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre'      => 'required|string|max:191',
            'siglas'     => 'required|string|max:191'
        ]);


        $unidadorganica = UnidadOrganica::create([
            'nombre' => $request->nombre,
            'siglas' => $request->siglas
        ]);

        return $unidadorganica;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return UnidadOrganica::where('id','=',$id)->first();
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
        $unidadorganica = UnidadOrganica::where('id','=',$id)->first();

         //Validamos datos a Modificar
        $this->validate($request, [
            'nombre'      => 'required|string|max:191',
            'siglas'     => 'required|string|max:191',
        ]);
      
        //Actualizamos datos de la Unidad Orgánica Seleccionada
        $unidadorganica->nombre = $request->nombre;
        $unidadorganica->siglas = $request->siglas;
        $unidadorganica->save();
            
        //Mensaje de Satisfactorio
        return $unidadorganica;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unidadorganica = UnidadOrganica::where('id','=',$id)->first();
        $unidadorganica->delete();

        return $unidadorganica;
    }

    public function lista() 
    {
        return UnidadOrganica::select('id','nombre','siglas')->get();
    }
    
    public function listaMovimiento() {
        return UnidadOrganica::select('id','nombre','siglas')->get();
    }
}
