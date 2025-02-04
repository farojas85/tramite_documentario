<?php

namespace App\Http\Controllers\API;

use App\Persona;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Peru\Http\ContextClient;
use Peru\Jne\{Dni, DniParser};
use Peru\Sunat\{HtmlParser, Ruc, RucParser};

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
            'name'      => 'required|string|max:191',
            'email'     => 'required|string|email|max:191|unique:users',
            'password'  => 'required|string|min:8',
            'role_id' => 'required'
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->roles()->attach($request->role_id);

        return $user;
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

    public function buscar_dni(Request $request) {
        $persona = Persona::where('numero_documento','=',$request->documento)->first();
        $persona_count = Persona::where('numero_documento','=',$request->documento)->count();

        if($persona_count == 0 )
        {
            $cs = new Dni(new ContextClient(), new DniParser());

            $person = $cs->get($request->documento);

            if (!$person) {
                return  'No Encontrado';
            }

            $person = [ 
                'nombres' => $person->nombres,
                'apellidos' => $person->apellidoPaterno." ".$person->apellidoMaterno,
                'correo' =>'',
                'direccion' => ''
            ];
        }
        else {
            $person = [
                'nombres' => $persona->nombres,
                'apellidos' => $persona->apellidos,
                'correo' => $persona->correo,
                'direccion' => $persona->direccion
            ];
        }
        return json_encode($person);
    }

    public function buscar_ruc(Request $request) {

        $persona = Persona::where('numero_documento','=',$request->documento)->first();
        $persona_count = Persona::where('numero_documento','=',$request->documento)->count();

        if($persona_count == 0 )
        {
            $cs = new Ruc(new ContextClient(), new RucParser(new HtmlParser()));

            $company = $cs->get($request->documento);

            if (!$company) {
                return 'No Encontrado';
            }

            $company = [
                'razon_social' => $company->razonSocial,
                'correo' => '',
                'direccion' => $company->direccion
            ];
        }
        else {
            $company = [
                'razon_social' => $persona->razon_social,
                'correo' => $persona->correo,
                'direccion' => $persona->direccion
            ];
        }

        return json_encode($company);
    }
}
