<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Almacen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $user = User::find(Auth::id());
            $user_rol = $user->getRoleNames();
        if ($user_rol[0] == 'almacen' || $user_rol[0] == 'admin') { //Si esta logueado y es personal de almacen, lo deja acceder
            return $next($request);
        } else { //Si no, lo manda al inicio del panel
            return redirect()->route('Welcome');
        }
    }
    }

    

