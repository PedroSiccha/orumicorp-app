<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MessageWhatsappModel;
use App\Services\CallbellService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CallbellController extends Controller
{
    protected $callbellService;

    public function __construct(CallbellService $callbellService)
    {
        $this->callbellService = $callbellService;
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
        ]);

        $response = $this->callbellService->sendMessage($request->phone, $request->message);

        MessageWhatsappModel::create([
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => $response['message']['status'] ?? 'unknown',
            'agent_id' => 1,
            'customer_id' => 1
        ]);

        return response()->json($response);
    }

    public function searchContact(Request $request)
    {
        // Validamos el número de teléfono que nos llega
        $request->validate([
            'phone' => 'required|string',
        ]);

        // Llamamos al servicio que hará la consulta a la API de Callbell
        try {
            $response = $this->callbellService->buscarContactoPorTelefono($request->phone);

            // Si la respuesta contiene el contacto, lo retornamos
            if (isset($response['contact'])) {
                return response()->json([
                    'contact' => $response['contact'],
                ]);
            }

            // Si no hay contacto, devolvemos un mensaje de no encontrado
            return response()->json([
                'message' => 'No se encontró el contacto.',
            ], 404);

        } catch (\Exception $e) {
            // En caso de error, logueamos el error y devolvemos un mensaje de error genérico
            Log::error('Error al buscar el contacto: ' . $e->getMessage());
            return response()->json([
                'message' => 'Hubo un error al procesar la solicitud.',
            ], 500);
        }
    }

    public function viewHistory()
    {
        $messages = MessageWhatsappModel::all();
        return view('callbell.history', compact('messages'));
    }
}
