<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\VoisoService;
use Illuminate\Http\Request;

class CallController extends Controller
{
    protected $voisoService;
    public function __construct(VoisoService $voisoService)
    {
        $this->voisoService = $voisoService;
    }

    public function makeCall()
    {
        $phoneNumber = '+51910832955'; // Número de teléfono al que llamar
        $message = 'Hola, esto es una llamada de prueba desde Laravel.'; // Mensaje a reproducir en la llamada

        $response = $this->voisoService->makeCall($phoneNumber, $message);

        // Manejar la respuesta de la llamada, por ejemplo, redireccionar con un mensaje de éxito
        return redirect()->back()->with('success', 'Llamada realizada con éxito.');
    }
}
