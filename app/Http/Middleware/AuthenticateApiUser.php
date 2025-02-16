<?php

namespace App\Http\Middleware;

use App\Models\ApiUser;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class AuthenticateApiUser
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
        $authorizationHeader = $request->header('Authorization');
        // Verificar si el token viene en el header
        if (!$authorizationHeader || !str_starts_with($authorizationHeader, 'Bearer ')) {
            return response()->json(['message' => 'Token no proporcionado o inválido'], 401);
        }
         // Extraer el token del header
        $token = substr($authorizationHeader, 7);
         // Buscar usuario con ese token
        $user = ApiUser::where('token', $token)->first();
        if (!$user || Carbon::now()->greaterThan($user->token_expiry)) {
            return response()->json(['message' => 'Token inválido o expirado'], 401);
        }
        // Pasar el usuario autenticado en la petición
        $request->attributes->add(['user' => $user]);
        return $next($request);
    }
}
