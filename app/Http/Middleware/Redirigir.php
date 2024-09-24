<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Redirigir
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

        switch ($user_rol[0]) {
            case 'almacen':
                return redirect()->route('pedidosPagados');
                break;
            case 'admin':
                return redirect()->route('home');
                break;
            case 'vendedor':
                return redirect()->route('venta.index');
                break;
            case 'cajero':
                return redirect()->route('venta.index');
                break;
                
            default:
            return $next($request);
            break;
        }
    }
    }

    

