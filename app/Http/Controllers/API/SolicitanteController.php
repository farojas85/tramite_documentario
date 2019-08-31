<?php

namespace App\Http\Controllers\API;

use App\Solicitante;
use App\Persona;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SolicitanteController extends Controller
{

    public function index()
    {       
        return DB::table('solicitantes as s')
                    ->join('personas as p','s.persona_id','=','p.id')
                    ->join('documento_identidads as di','p.documento_identidad_id','=','di.id')
                    ->select('s.id','p.nombres','p.apellidos','p.razon_social',
                            'p.documento_identidad_id','di.descripcion_corta',
                            'p.numero_documento','s.estado','s.created_at')
                    ->latest()->paginate(5);
    }

    public function store(Request $request)
    {

        $persona = Persona::create([
            'nombres' => $request->persona['nombres'],
            'apellidos' => $request->persona['apellidos'],
            'razon_social' => $request->persona['razon_social'],
            'documento_identidad_id' => $request->persona['documento_identidad_id'],
            'numero_documento' => $request->persona['numero_documento'],
            'correo' => $request->persona['correo'],
            'direccion' => $request->persona['direccion']
        ]);

        $persona_id = $persona->id;

        $solicitante = Solicitante::create([
            'persona_id' => $persona_id
        ]);

        return $solicitante;
    }

    public function show($id)
    {
        $solicitante = DB::table('solicitantes as s')
                            ->join('personas as p','s.persona_id','=','p.id')
                            ->join('documento_identidads as di','p.documento_identidad_id','=','di.id')
                            ->select('s.id','p.nombres','p.apellidos','p.razon_social',
                                    'p.documento_identidad_id','di.descripcion_corta',
                                    's.persona_id','p.numero_documento','p.correo','p.direccion',
                                    's.estado','s.eliminado','s.created_at')
                            ->where('s.id','=',$id)->get();

        return $solicitante;
    }

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

    public function destroy($id)
    {
        $solicitante = Solicitante::where('id','=',$id)->first();

        $persona_id = $solicitante->persona_id;

        $solicitante->delete();

        $persona = Persona::where('id','=',$persona_id)->first();
        $persona->delete();
    }
}
