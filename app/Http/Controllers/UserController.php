<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        //$users = User::latest()->get();
        $users = User::with('roles')->role(['admin', 'vendedor', 'almacen', 'cajero'])->get();
        //return $users;

        return view('panel.administrador.lista_usuarios.index', compact('users'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Creamos UN Usuario nuevo para cargarle datos
        $user = new User();
        
        $user_role = $user->getRoleNames();
        $all_roles = Role::all()->pluck('name'); //guardo todos los roles existentes

        //Retornamos la vista de creacion de users, enviamos al user y las categorias
        return view('panel.administrador.lista_usuarios.create', compact('user', 'user_role', 'all_roles')); //compact(mismo nombre de la variable)
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {

        $user = new User();


        //Si pasa la validación prosigue a crear el nuevo user en la BD y asignar el rol
        $user->name = $request->get('name');
        $user->apellido = $request->get('apellido');
        $user->dni = $request->get('dni');
        $user->telefono = $request->get('telefono');
        $user->direccion = $request->get('direccion');
        $user->email = $request->get('email');
        $user->password = $request->get('password');

        //asignación de nuevo rol
        $rolSeleccionado = $request->get('rol_id'); //obtengo el rol seleccionado del form (siempre debe llamarse rol_id)
        $nuevoRol = Role::where('name', $rolSeleccionado)->first(); //busca el nuevo rol traido del form en la bd de spatie
        $user->roles()->detach(); //elimino el rol del usuario
        $user->assignRole($nuevoRol); //asigno rol

        // Almacena la info del user en la BD
        $user->save();

        return redirect()
        ->route('user.index')
        ->with('alert', 'User "' . $user->name. " " .$user->apellido . '" agregado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return view('panel.administrador.lista_usuarios.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user_role = $user->getRoleNames();
        $all_roles = Role::all()->pluck('name'); //guardo todos los roles existentes
        //var_dump($all_roles_in_database);die();
        return view('panel.administrador.lista_usuarios.edit', compact('user', 'user_role', 'all_roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        
        $user->name = $request->get('name');
        $user->apellido = $request->get('apellido');
        /*$user->dni = $request->get('dni'); */
        $user->telefono = $request->get('telefono');
        $user->direccion = $request->get('direccion');
        $user->email = $request->get('email');
        $nuevaPassword = $request->get('password'); //no se asigna directamente al obj $user

        // Verifica si se rellenó el campo de contraseña para encriptarla
        if (!empty($nuevaPassword)) {
            $user->password = Hash::make($nuevaPassword);    
        }

        //asignación de nuevo rol
        $rolSeleccionado = $request->get('rol_id'); //obtengo el rol seleccionado del form (siempre debe llamarse rol_id)
        $nuevoRol = Role::where('name', $rolSeleccionado)->first(); //busca el nuevo rol traido del form en la bd de spatie
        $user->roles()->detach(); //elimino el rol del usuario
        $user->assignRole($nuevoRol); //asigno rol
        

        // Actualiza la info del user en la BD
        $user->update();
        
        return redirect()
            ->route('user.index')
            ->with('alert', 'User "' .$user->name. " " .$user->apellido. '" actualizado exitosamente.');
    }

    public function cambiarEstado(Request $request)
    {
        $user = User::find($request->_id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrada'], 404);
        }

        $user->enabled = !$user->enabled; // Cambia el estado
        $user->save();

        return response()->json(['message' => 'Estado de Usuario cambiado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        
        $user->delete();

        return redirect()
        ->route('user.index')
        ->with('alert', 'User eliminado exitosamente');
    }


}
