<?php

namespace App\Http\Middleware;

use App\Models\AllowedIP;
use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        $ipLocal = $_SERVER['REMOTE_ADDR'];
        //dd($ipLocal);
        $client = new Client();

        try {
            $response = $client->request('GET', 'https://api.ipify.org');
            $ip = $response->getBody()->getContents();
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Acceso denegado, '.$th], 403);
        }

        $allowedIPs = AllowedIP::where('status', 1)->pluck('ip')->toArray();

        if (!in_array($ip, $allowedIPs)) {
            //return response()->json(['error' => 'Acceso denegado.'], 403);
            return response()->view('error.sinacceso', [], 404);
        }
        return $next($request);
    }
}
