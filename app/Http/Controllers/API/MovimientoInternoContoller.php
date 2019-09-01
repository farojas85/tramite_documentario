<?php

namespace App\Http\Controllers\API;

use App\MovimientoInterno;
use App\Movimiento;
use App\Expediente;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovimientoInternoContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'unidad_destino' => 'required',
            'dependencia_destino' => 'required'
        ]);  
        
        $movimiento_interno_count = MovimientoInterno::where('movimiento_id','=',$request->movimiento_id)->count();
        
        if($movimiento_interno_count == 0) {
            $expediente = Expediente::where('id','=',$request->expediente_id)->first();
            $expediente->estado = "Derivado";
            $expediente->save();

            $movimiento = Movimiento::where('id','=',$request->movimiento_id)->first();
            $movimiento->estado_actual = 'Derivado';
            $movimiento->save();
        }

        $movimiento_interno =new  MovimientoInterno();
        $movimiento_interno->movimiento_id = $request->movimiento_id;
        $movimiento_interno->unidad_destino = $request->unidad_destino;
        $movimiento_interno->dependencia_destino = $request->dependencia_destino;
        $movimiento_interno->cargo_destino = $request->cargo_destino;
        $movimiento_interno->save();
        
        if($movimiento_interno_count == 0) {
            $movimiento = Movimiento::where('id','=',$request->movimiento_id)->first();
            $movimiento->motivos()->attach($request->motivo_id);
        }

        return ['mensaje' => 'Movimiento Interno Registrado Satisfactoriamente'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function by_movimiento_id(Request $request) {
        return DB::table('movimiento_internos as mi')
                    ->join('unidad_organicas as uo','mi.unidad_destino','=','uo.id')
                    ->join('dependencias as de','mi.dependencia_destino','=','de.id')
                    ->leftJoin('cargos as ca','mi.cargo_destino','=','ca.id')
                    ->where('movimiento_id','=',$request->movimiento_id)
                    ->select(
                        'mi.id','uo.nombre as unidad_destino','de.nombre as dependencia_destino',
                        'ca.nominativo_interno as cargo_destino','mi.created_at'
                    )
                    ->get();

    }
}
