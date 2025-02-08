<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\MessageWhatsappModel;
use App\Services\CallbellService;
use Carbon\Carbon;
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

    public function updateCallbellCustomer(Request $request)
    {
        // Validamos el número de teléfono recibido
        $request->validate([
            'id' => 'required',
            'phone' => 'required|string',
        ]);

        try {
            // Consultamos la API de Callbell
            $response = $this->callbellService->buscarContactoPorTelefono($request->phone);

            // Verificamos si se obtuvo el contacto
            if (!isset($response['contact'])) {
                return response()->json([
                    'message' => 'No se encontró el contacto en Callbell.',
                ], 404);
            }

            // Extraemos los datos del contacto
            $contactData = $response['contact'];

            // Buscamos si el cliente ya existe en la base de datos por UUID o teléfono
            $customer = Customers::where('id', $request->id)
                                    ->orWhere('phone', $contactData['phoneNumber'])
                                    ->first();

            $customer->callbell_uuid = $contactData['uuid'];
            $customer->closed_at = $contactData['closedAt'];
            $customer->callbel_source = $contactData['source'];
            $customer->callbell_href = $contactData['href'];
            $customer->callbell_conversationHref = $contactData['conversationHref'];
            $customer->callbel_tags = json_encode($contactData['tags'] ?? []);
            $customer->callbel_custom_fields = json_encode($contactData['customFields'] ?? []);
            $customer->callbel_team = json_encode($contactData['team'] ?? []);
            $customer->callbel_channel = json_encode($contactData['channel'] ?? []);
            $customer->callbel_blocked_at = $contactData['blockedAt'];
            $customer->save();

            // Retornamos la respuesta con el cliente actualizado o creado
            // return response()->json([
            //     'message' => 'Cliente actualizado correctamente.',
            //     'customer' => $customer,
            // ]);

            $baseUrl = env('CALLBELL_API_BASE_URL');
            $token = env('CALLBELL_API_TOKEN');
            // dd($request->uuid);

            $response = Http::withToken($token)->get("{$baseUrl}/contacts/{$request->uuid}/messages");

            if ($response->successful()) {
                $messages = $response->json()['messages'];

                usort($messages, function ($a, $b) {
                    return strtotime($a['createdAt']) - strtotime($b['createdAt']);
                });

                foreach ($messages as &$message) {
                    $message['createdAt'] = Carbon::parse($message['createdAt'])->format('d/m/Y H:i:s');
                }

                return response()->json(['messages' => $messages]);
            } else {
                return response()->json(['error' => 'Error al obtener los mensajes'], 500);
            }

        } catch (\Exception $e) {
            // Logueamos el error en caso de fallo
            Log::error('Error al actualizar el contacto de Callbell: ' . $e->getMessage());

            return response()->json([
                'message' => 'Hubo un error al procesar la solicitud.',
            ], 500);
        }
    }

}
