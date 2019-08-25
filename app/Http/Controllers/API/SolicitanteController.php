<?php

namespace App\Http\Controllers\API;

use App\Solicitante;
use App\Persona;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SolicitanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Solicitante::with('persona')->latest()->paginate(5);
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
            'documento_identidad_id'      => 'required',
            'numero_documento'     => 'required|string|max:20',
            'persona_id'  => 'required|unique:personas'
        ]);

        $persona = Persona::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->nombres,
            'razon_social' => $request->razon_social,
            'documento_identidad_id' => $request->documento_identidad_id,
            'numero_documento' => $request->numero_documento,
            'correo' => $request->correo,
            'direccion' => $request->direccion
        ]);

        $persona_id = $persona->id();

        $solicitante = Solicitante::create([
            'persona_id' => $persona_id
        ]);

        return $solicitante;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $solicitante = Solicitante::with('persona')->with('DocumentoIdentidad')->where('id','=',$id)->first();

        return $solicitante;
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
        $this->validate($request, [
            'documento_identidad_id'      => 'required',
            'numero_documento'     => 'required|string|max:20',
            'persona_id'  => 'required|unique:personas'
        ]);

        $persona = Persona::update([
            'nombres' => $request->nombres,
            'apellidos' => $request->nombres,
            'razon_social' => $request->razon_social,
            'documento_identidad_id' => $request->documento_identidad_id,
            'numero_documento' => $request->numero_documento,
            'correo' => $request->correo,
            'direccion' => $request->direccion
        ]);

        $persona_id = $persona->id();

        $solicitante = Solicitante::update([
            'persona_id' => $persona_id,
            'estado' => $request->estado,
            'eliminado' => $request->eliminado
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $solicitante = Solicitante::where('id','=',$id)->first();

        $persona_id = $solicitante->persona_id;

        $solicitante->delete();

        $persona = Persona::where('id','=',$persona_id)->first();
        $persona->delete();
    }
}
