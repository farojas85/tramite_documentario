<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Persona;
use App\Empleado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api');
    }
    
    public function index()
    {
        return User::with('roles')->latest()->paginate(5);
    }

    public function store(Request $request)
    {
        //return $request->persona['nombres'];
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
        
        $user_id = $user->id;
        $user->roles()->attach($request->role_id);

        //Insertamos Datos Personales
        $persona = new Persona();
        $persona->documento_identidad_id = $request->persona['documento_identidad_id'];
        $persona->numero_documento = $request->persona['numero_documento'];
        $persona->nombres = $request->persona['nombres'];
        $persona->apellidos = $request->persona['apellidos'];
        $persona->correo = $request->persona['correo'];
        $persona->direccion = $request->persona['direccion'];
        $persona->save();

        $persona_id =$persona->id;

        //Insertamos Datos del Empleado
        $empleado = new Empleado();
        $empleado->user_id = $user_id;
        $empleado->persona_id = $persona_id;
        $empleado->cargo_id = $request->empleado['cargo_id'];
        $empleado->estado = 1;        
        $empleado->save();

        return $user;
    }

    public function show($id)
    {        
        return User::with('roles')->where('id','=',$id)->first();
    }

    public function mostrar(Request $request) {
        return DB::table('users as us')
                        ->join('role_user as ru','us.id','=','ru.user_id')
                        ->join('roles as ro','ru.role_id','=','ro.id')
                        ->leftJoin('empleados as emp','us.id','=','emp.user_id')
                        ->join('personas as per','emp.persona_id','=','per.id')
                        ->join('cargos as car','emp.cargo_id','=','car.id')
                        ->join('dependencias as dep','car.dependencia_id','=','dep.id')
                        ->join('unidad_organicas as uo','dep.unidad_organica_id','=','uo.id')                        
                    ->where('us.id','=',$request->id)
                    ->select('us.id as user_id','us.name as user_name','us.email as user_email','ro.nombre as role_name',
                            'per.documento_identidad_id','per.numero_documento','per.nombres','emp.id as empleado_id',
                            'per.apellidos','per.direccion','emp.cargo_id','car.dependencia_id','ru.role_id',
                            'dep.unidad_organica_id','per.id as persona_id')
                    ->get();
    }

    public function update(Request $request, $id)
    {
        //obtenemos Usuario a Actualizar
        $user = User::with('roles')->with('empleado')->where('id','=',$id)->first();

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

        $user_id = $user->id;
        

        return "Registro Modificado Satisfactoriamente";
    }

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
        return User::with('roles')->where('name','LIKE'.$cadena)->latest()->paginate(5);
    }

    public function perfil() {
        return auth('api')->user();
    }

    public function datosPersonales() {
        return Persona::with('DocumentoIdentidad')
                        ->where('user_id','=',auth('api')->user()['id'])->first();
    }
}
