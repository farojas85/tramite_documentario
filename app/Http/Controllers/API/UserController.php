<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('roles')->latest()->paginate(5);
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
        return User::with('roles')->where('id','=',$id)->first();
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
        //obtenemos Usuario a Actualizar
        $user = User::with('roles')->where('id','=',$id)->first();

        //Validamos datos a Modificar
        $this->validate($request, [
            'name'      => 'required|string|max:191',
            'email'     => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'role_id' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->foto = $request->foto;
        //recorremos el rol que tiene
        foreach($user->roles as $role) {
            $role_id = $role->id;
        }
        if($user->role_id != $request->role_id){
            $user->roles()->detach($role_id);
            $user->roles()->attach($request->role_id);
        }
        
        $user->save();

        return "Registro Modificado Satisfactoriamente";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //obtenemos Usuario a Eliminar
        $user = User::with('roles')->where('id','=',$id)->first();

        //recorremos el rol que tiene
        foreach($user->roles as $role) {
            $role_id = $role->id;
        }
        //Separamos los datos de la tabla pivote
        $user->roles()->detach($role_id);
        $user->delete();

        return "Registro Eliminado Satisfactoriamente";
    }

    public function search($busqueda){
        //video 16
       // return $cadena;
        return User::with('roles')->where('name','LIKE'.$cadena)->latest()->paginate(5);
    }
}
