<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIPRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Lista de IP permitidas
        $allowedIPs = [
            '127.0.0.1', // Ejemplo de IP local
            '192.168.0.1' // Ejemplo de otra IP permitida
        ];
        $clientIP = $request->ip();
        if ($request->header('x-forwarded-for')) {
            $clientIP = $request->header('x-forwarded-for');
        }

        if (!in_array($clientIP, $allowedIPs)) {
            return response()->json(['error' => 'Acceso denegado.'], 403);
        }
        return $next($request);
    }
}
