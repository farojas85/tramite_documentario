<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class TramiteController extends Controller
{
    var $sssioni;
  
    public function index(Request $request)
    {
        $usuario = null;
        if(Auth::check()){
            $usuario = User::where('id','=',Auth::user()->id)->first();
            
        }
        if(!Session::has('busqueda_expediente')){
            Session::put('busqueda_expediente',$request->busqueda_expediente);
        }
        $expedientes = null;

        if($request->buscar_expediente == 'expediente'){
            return redirect('/');
        }
        else if($request->buscar_expediente!= null) {

            $expediente = DB::table('expedientes as exp')
                            ->join('documentos as doc','exp.id','=','doc.expediente_id')
                            ->where('numero_expediente','=',$request->buscar_expediente)
                            ->select('exp.id','exp.fecha','exp.hora','exp.cabecera',
                                    'exp.numero_expediente','doc.asunto as asunto',
                                    'exp.estado'
                            )
                            ->get();
            foreach ($expediente as $exp) {
                $movimientos = DB::table('movimientos as mov')
                                        ->join('tipo_movimientos as tm','mov.tipo_movimiento_id','=','tm.id')
                                        ->join('unidad_organicas as uo','mov.unidad_origen','=','uo.id')
                                        ->join('dependencias as de','mov.dependencia_origen','=','de.id')
                                    ->where('expediente_id','=',$exp->id)
                                    ->select('mov.id','tm.descripcion as tipo_movimiento',
                                        'uo.nombre as unidad_origen','de.nombre as dependencia_origen',
                                        'mov.estado_actual'
                                        )
                                    ->get();
                foreach($movimientos as $movi)
                {
                    $motivos = DB::table('motivo_movimiento as mm')
                                        ->join('motivos as mo','mm.motivo_id','=','mo.id')
                                        ->join('movimientos as mv','mm.movimiento_id','=','mv.id')
                                        ->where('mm.movimiento_id','=',$movi->id)
                                        ->select('mm.motivo_id','mo.motivo')
                                        ->get();
                    $movimiento_internos = DB::table('movimiento_internos as mi')
                                                    ->join('unidad_organicas as uo','mi.unidad_destino','=','uo.id')
                                                    ->join('dependencias as de','mi.dependencia_destino','=','de.id')
                                                    ->leftJoin('cargos as ca','mi.cargo_destino','=','ca.id')
                                                ->where('mi.movimiento_id','=',$movi->id)
                                                ->select('mi.id','uo.nombre as unidad_destino','de.nombre as dependencia_destino',
                                                        'ca.nominativo_interno as cargo_destino','mi.created_at as fecha_creada')
                                                ->get();

                }
            }

            $expedientes  = [
                'expediente' => $expediente,
                'movimientos' => $movimientos,
                'motivos' => $motivos,
                'movimiento_internos' => $movimiento_internos
            ];
        }
        
        return view('tramite',compact('usuario','expedientes'));
    }

}
