<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ClienteRequest;
use Illuminate\Support\Facades\Auth;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();
        $cliente = User::with('roles')->role(['cliente'])->where('id', $user_id)->first();
        return view('panel.index', compact('cliente'));  
        /* $user_id = Auth::id();
        $clientes = User::with('roles')->role(['cliente'])->where('id', $user_id)->get();
        return view('panel.cliente.lista_usuarios.index', compact('clientes')); */ 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editar()
    {
        
        $user_id = Auth::id();
        $cliente = User::with('roles')->where('id', $user_id)->first();
        $user_role = $cliente->getRoleNames();
        $all_roles = Role::all()->pluck('name'); //guardo todos los roles existentes
        //var_dump($all_roles_in_database);die();
        return view('panel.cliente.lista_usuarios.edit', compact('cliente','user_role','all_roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function actualizar(ClienteRequest $request, $user_id)
    {

        /* dd($request); */

        $user = User::with('roles')->where('id', $user_id)->first();
        $user->name = $request->get('name');
        $user->apellido = $request->get('apellido');
        $user->dni = $request->get('dni'); 
        $user->telefono = $request->get('telefono');
        $user->direccion = $request->get('direccion');
        $user->email = $request->get('email');
        $nuevaPassword = $request->get('password'); //no se asigna directamente al obj $user
        // Verifica si se rellenó el campo de contraseña para encriptarla

        if (!empty($nuevaPassword)) {
            $user->password = Hash::make($nuevaPassword);    
        }

        if (!empty($request->get('password_confirmation')) && empty($request->get('current_password'))) {
            return redirect()
            ->route('cliente.editar')
            ->with('error', 'Debe completar con la contraseña anterior!');
            }
        if (!empty($request->get('current_password')) && empty($nuevaPassword)) {
                return redirect()
                ->route('cliente.editar')
                ->with('error', 'Debe completar con las nuevas contraseñas!');
        }
        if (!empty($nuevaPassword) && !empty($request->get('current_password'))){ //si escribio una contraseña anterior, verifica que sea correcta, si no lo es, no va a actualizar nada
            if (!Hash::check($request->get('current_password'), Auth::user()->password)) {
            return redirect()
            ->route('cliente.editar')
            ->with('error', 'Contraseña actual incorrecta!');
            }
        } else if(!empty($nuevaPassword) && empty($request->get('current_password'))){//si escribe una nueva contraseña, debe escribir si o si la actual
            return redirect()
            ->route('cliente.editar')
            ->with('error', 'Debe ingresar la contraseña actual!');
        }
        // Actualiza la info del user en la BD
        $user->update();
        
        return redirect()
            ->route('cliente.editar')
            ->with('alert', 'Usuario "' .$user->name. " " .$user->apellido. '" actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
