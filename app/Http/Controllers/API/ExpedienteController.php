<?php

namespace App\Http\Controllers\API;

use App\Solicitante;
use App\Persona;
use App\Documento;
use App\Expediente;
use App\Movimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;


class ExpedienteController extends Controller
{
    public function index()
    {
        return Expediente::with('documento')->latest()->paginate(5);
    }

    public function store(Request $request)
    {
        //Insertamos Persona 
        $persona_id =0;
        $persona_count = Persona::where('numero_documento','=',$request->persona['numero_documento'])->count();
        if($persona_count == 0) {
            $persona = new Persona();
            if($request->persona['documento_identidad_id'] == 3) {
                $persona->razon_social = $request->persona['razon_social'];
            }
            else {
                $persona->nombres = $request->persona['nombres'];
                $persona->apellidos = $request->persona['apellidos'];
            }
            $persona->correo = $request->persona['correo'];
            $persona->direccion = $request->persona['direccion'];
            $persona->documento_identidad_id = $request->persona['documento_identidad_id'];
            $persona->numero_documento = $request->persona['numero_documento'];

            $persona->save();

            $persona_id = $persona->id;
        }
        else {
            $persona = Persona::where('numero_documento','=',$request->persona['numero_documento'])->first();
            $persona_id = $persona->id;
        }

        //Insertamos Solicitante
        $solicitante_count = Solicitante::where('persona_id','=',$persona_id)->count();
        $solicitante_id = 0;
        if($solicitante_count == 0) {
            $solicitante = new Solicitante();
            $solicitante->persona_id = $persona_id;
            $solicitante->estado = $request->solicitante['estado'];
            $solicitante->eliminado = $request->solicitante['eliminado'];

            $solicitante->save();
            $solicitante_id = $solicitante->id;
        }
        else {
            $solicitante = Solicitante::where('persona_id','=',$persona_id)->first();
            $solicitante_id = $solicitante->id;
        }

        //REGISTRAMOS EXPEDIENTE
        $expediente = new Expediente();
        $expediente->fecha = Carbon::now()->format('Y-m-d');
        $expediente->hora = Carbon::now()->format('H:i:s');
        $expediente->cabecera = $request->expediente['cabecera'];
        $expediente->numero_expediente = $request->expediente['numero_expediente'];
        $expediente->procedimiento_id = $request->expediente['procedimiento_id'];
        $expediente->user_id = auth('api')->user()['id'];
        //$expediente->observaciones = $request->expediente['observaciones'];
        $expediente->observaciones = '';
        $expediente->estado = 'Pendiente';
        $expediente->prioridad="Ninguna";
        $expediente->save();

        $expediente_id = $expediente->id;

        //INSERTAMOS EL DOCUMENTO
        $documento = new Documento();
        $documento->tipo_documento_id = $request->documento['tipo_documento_id'];
        $documento->expediente_id = $expediente_id;
        $documento->cabecera_documento = $request->documento['cabecera'];
        $documento->numero_documento  = $request->documento['numero_documento'];
        $documento->asunto = $request->documento['asunto'];
        $documento->folios = $request->documento['folios'];
        $documento->save();

        //Insertamos Movimiento
        $movimiento = new Movimiento();
        $movimiento->tipo_movimiento_id = $request->movimiento['tipo_movimiento_id'];
        $movimiento->expediente_id = $expediente_id;
        $movimiento->unidad_origen=8;
        $movimiento->dependencia_origen=30;
        $movimiento->fecha = Carbon::now()->format('Y-m-d');
        $movimiento->hora = Carbon::now()->format('H:i:s');
        $movimiento->numero_recepcion = '';
        $movimiento->observaciones='';
        $movimiento->prioridad='';
        $movimiento->estado_actual ='Pendiente';

        $movimiento->save();

        $solicitante->movimientos()->attach($movimiento->id);

        return 'Datos registrados Satisfactoriamente';
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
