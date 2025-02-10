<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Customers;
use App\Models\MessageWhatsappModel;
use App\Models\Premio;
use App\Models\User;
use App\Services\CallbellService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

         // Acceder a los datos correctamente
         $uuid = $response['message']['message']['uuid'] ?? null;
         $status = $response['message']['message']['status'] ?? null;

        // Verificar si UUID es válido antes de continuar
        if (!$uuid) {
            Log::error("No se recibió un UUID válido de Callbell.", ['response' => $response]);
            return response()->json(['error' => 'No se pudo obtener un UUID válido'], 500);
        }

        $responseStatusMessage = $this->callbellService->getMessageStatus($uuid);
        Log::info("responseStatusMessage:", $responseStatusMessage);
        // 💡 Verifica si Callbell devolvió el estado correctamente
        if (!isset($responseStatusMessage['message'])) {
            Log::error("Error al obtener el estado del mensaje", ['response' => $responseStatusMessage]);
            return response()->json(['error' => 'No se pudo obtener el estado del mensaje'], 500);
        }

        $contactUuid = $responseStatusMessage['message']['contact']['uuid'] ?? null;
        $source = $responseStatusMessage['message']['conversation']['source'] ?? null;
        $closed_at = $responseStatusMessage['message']['contact']['closedAt'] ?? null;
        $href = $responseStatusMessage['message']['contact']['href'] ?? null;
        $conversationHref = $responseStatusMessage['message']['contact']['conversationHref'] ?? null;
        $tags = $responseStatusMessage['message']['contact']['tags'] ?? null;
        $team = $responseStatusMessage['message']['contact']['team']['uuid'] ?? null;
        $channel = $responseStatusMessage['message']['contact']['channel']['type'] ?? null;
        $blockedAt = $responseStatusMessage['message']['contact']['blockedAt'] ?? null;
        Log::info("contactUuid ". $contactUuid);

        $client = Customers::where('phone', $request->phone)->first();
        if (!$client) {
            Log::error("Cliente no encontrado para el número: " . $request->phone);
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }
        $client->uuid = $contactUuid;
        // $client->call_black
        $client->callbell_uuid = $contactUuid;
        // $client->call_init
        $client->closed_at = $closed_at;
        $client->callbel_source = $source;
        $client->callbell_href = $href;
        $client->callbell_conversationHref = $conversationHref;
        $client->callbel_tags = $tags;
        $client->callbel_team = $team;
        $client->callbel_channel = $channel;
        $client->callbel_blocked_at = $blockedAt;
        $client->save();

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();
        $agent = Agent::where('user_id', $user_id)->first();
        $dataUser = $agent;
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $rouletteSpin = $agent->number_turns ?: 0;

        $baseUrl = env('CALLBELL_API_BASE_URL');
        $token = env('CALLBELL_API_TOKEN');


        MessageWhatsappModel::create([
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => $status,
            'uuid' => $uuid,
            'agent_id' => $agent->id,
            'customer_id' => $client->id
        ]);

        $contacts = Customers::all()->map(function ($customer) {
            return [
                "id" => $customer->id,  // Suponiendo que `id` es el identificador único
                "uuid" => $customer->callbell_uuid,  // Suponiendo que `id` es el identificador único
                "name" => $customer->name,
                "lastname" => $customer->lastname,
                "phoneNumber" => $customer->phone, // Ajusta según el nombre del campo en la DB
                "avatarUrl" => $customer->img ?? null,
                "createdAt" => $customer->created_at->format('d/m/Y'),
                "closedAt" => $customer->closed_at ? $customer->closed_at->format('d/m/Y') : null,
                "source" => $customer->callbel_source ?? "unknown",
                "href" => $customer->callbell_href,
                "conversationHref" => $customer->callbell_conversationHref,
                "tags" => $customer->callbel_tags ?? [],
                "assignedUser" => $customer->assigned_user_email ?? null,
                "customFields" => $customer->callbel_custom_fields ?? [],
                "team" => $customer->callbel_team ?? [],
                "channel" => $customer->callbel_channel ?? [],
                "blockedAt" => $customer->callbel_blocked_at ?? null,
            ];
        });

        if ($request->ajax()) {
            // return response()->json(['contacts' => $contacts]);
            return response()->json(["view"=>view('whatsapp.components.list.listContacts', compact('contacts'))->render()]);
        }


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

    public function filterChannel(Request $request) {

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();
        $agent = Agent::where('user_id', $user_id)->first();
        $dataUser = $agent;
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $rouletteSpin = $agent->number_turns ?: 0;

        $baseUrl = env('CALLBELL_API_BASE_URL');
        $token = env('CALLBELL_API_TOKEN');

        $contacts = Customers::where('callbel_channel', $request->channel)->get()->map(function ($customer) {
            return [
                "id" => $customer->id,  // Suponiendo que `id` es el identificador único
                "uuid" => $customer->callbell_uuid,  // Suponiendo que `id` es el identificador único
                "name" => $customer->name,
                "lastname" => $customer->lastname,
                "phoneNumber" => $customer->phone, // Ajusta según el nombre del campo en la DB
                "avatarUrl" => $customer->img ?? null,
                "createdAt" => $customer->created_at->format('d/m/Y'),
                "closedAt" => $customer->closed_at ? $customer->closed_at->format('d/m/Y') : null,
                "source" => $customer->callbel_source ?? "unknown",
                "href" => $customer->callbell_href,
                "conversationHref" => $customer->callbell_conversationHref,
                "tags" => $customer->callbel_tags ?? [],
                "assignedUser" => $customer->assigned_user_email ?? null,
                "customFields" => $customer->callbel_custom_fields ?? [],
                "team" => $customer->callbel_team ?? [],
                "channel" => $customer->callbel_channel ?? [],
                "blockedAt" => $customer->callbel_blocked_at ?? null,
            ];
        });

        if ($request->ajax()) {
            return response()->json(['contacts' => $contacts]);
        }

        return view('whatsapp.index', compact('premios1', 'premios2', 'rouletteSpin', 'dataUser', 'contacts','baseUrl', 'token'));
    }

}
