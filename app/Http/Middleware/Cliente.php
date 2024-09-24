<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cliente
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::find(Auth::id());

        if (isset($user)) { //Verifica si hay un usuario logueado
            $user_rol = $user->getRoleNames();

        if ($user_rol[0] == 'cliente') { //Si esta logueado y es cliente, lo manda a la tienda
            return $next($request);
        } else { //Si no es cliente, lo manda al panel
            return redirect()->route('home');
        }
        } else { //Si no hay nada logueado sigue normalmente
            return $next($request);
        }

        
        
        


    }
}
