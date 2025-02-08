<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\ClientInterface;
use App\Interfaces\ComunicationInterface;
use App\Models\Agent;
use App\Models\Assignment;
use App\Models\Comunications;
use App\Models\Customers;
use App\Models\Folder;
use App\Models\Premio;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    protected $comentarioService;
    protected $clientService;

    public function __construct(
        ComunicationInterface $comentarioService,
        ClientInterface $clientService
    ) {
        $this->comentarioService = $comentarioService;
        $this->clientService = $clientService;
    }

    public function whatsapp(Request $request)
    {
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

        // if (!$baseUrl) {
        //     throw new \Exception('CALLBELL_API_BASE_URL no está definido en el .env');
        // }

        // if (!$token) {
        //     throw new \Exception('CALLBELL_API_TOKEN no está definido en el .env');
        // }

        // $body = [
        //     'team_uuid' => '7929cea82d3745d38287b02877d49214'
        // ];

        // $page = $request->input('page', 1);
        // $response = Http::withToken($token)->withBody(json_encode($body), 'application/json')->get("{$baseUrl}/contacts?page={$page}");

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
            return response()->json(['contacts' => $contacts]);
        }

        // $contacts = Customers::all();

        // dd($contacts);

        return view('whatsapp.index', compact('premios1', 'premios2', 'rouletteSpin', 'dataUser', 'contacts','baseUrl', 'token'));

        //dd($response);

        // if ($response->successful()) {
        //     // $contacts = $response->json()['contacts'];
        //     // dd($contacts);
        //     // Ordenar los contactos por 'createdAt' de forma descendente

        //     $contacts = Customers::all()->map(function ($customer) {
        //         return [
        //             "uuid" => $customer->callbell_uuid,  // Suponiendo que `id` es el identificador único
        //             "name" => $customer->name,
        //             "phoneNumber" => $customer->phone, // Ajusta según el nombre del campo en la DB
        //             "avatarUrl" => $customer->img ?? null,
        //             "createdAt" => $customer->created_at->format('d/m/Y'),
        //             "closedAt" => $customer->closed_at ? $customer->closed_at->format('d/m/Y') : null,
        //             "source" => $customer->callbel_source ?? "unknown",
        //             "href" => $customer->callbell_href,
        //             "conversationHref" => $customer->callbell_conversationHref,
        //             "tags" => $customer->callbel_tags ?? [],
        //             "assignedUser" => $customer->assigned_user_email ?? null,
        //             "customFields" => $customer->callbel_custom_fields ?? [],
        //             "team" => $customer->callbel_team ?? [],
        //             "channel" => $customer->callbel_channel ?? [],
        //             "blockedAt" => $customer->callbel_blocked_at ?? null,
        //         ];
        //     });

        //     // $contacts = $contacts->json();

        //     // usort($contacts, function ($a, $b) {
        //     //     return strtotime($b['createdAt']) - strtotime($a['createdAt']);
        //     // });

        //     // foreach ($contacts as &$contact) {
        //     //     if (isset($contact['createdAt'])) {
        //     //         $contact['createdAt'] = Carbon::parse($contact['createdAt'])->format('d/m/Y');
        //     //     }
        //     //     if (isset($contact['closedAt'])) {
        //     //         $contact['closedAt'] = Carbon::parse($contact['closedAt'])->format('d/m/Y');
        //     //     }
        //     // }

        //     if ($request->ajax()) {
        //         return response()->json(['contacts' => $contacts]);
        //     }

        //     // $contacts = Customers::all();

        //     // dd($contacts);

        //     return view('whatsapp.index', compact('premios1', 'premios2', 'rouletteSpin', 'dataUser', 'contacts','baseUrl', 'token'));
        // } else {
        //     return abort(500, 'Error al obtener los contactos');
        // }
    }


    public function getChatDetails(Request $request)
    {
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
    }

    public function sendMessage(Request $request)
    {
        $baseUrl = env('CALLBELL_API_BASE_URL');
        $token = env('CALLBELL_API_TOKEN');

        // Formatear el número de teléfono
        // $phoneNumber = $this->formatPhoneNumber($request->input('to'));

        // Preparar el cuerpo de la solicitud
        $body = [
            "from" => "whatsapp",
            // "to" => $phoneNumber,
            "to" => "+51910832955",
            "type" => "text",
            "content" => [
                // "text" => $request->input('text'),
                "text" => "Esto es una prueba",
                // "url" => $request->input('url')
            ],
            "template_uuid" => $request->input('template_uuid'),
            "optin_contact" => $request->input('optin_contact', true)
        ];

        // Enviar la solicitud a la API de Callbell
        $response = Http::withToken($token)->post("{$baseUrl}/messages/send", $body);

        // Verificar la respuesta
        if ($response->successful()) {
            return response()->json(['message' => $response->json()['message']], 200);
        } else {
            return response()->json(['error' => 'Error al enviar el mensaje'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveComentario(Request $request)
    {

        if (empty($request->idComunication)) {
            $idComunication = '1';
        } else {
            $idComunication = $request->idComunication;
        }

        $dataCustomer = [
            'comunicationId' => $idComunication,
            'comment' => $request->txtComentario,
            'customerStatusId' => $request->customerStatusId
        ];

        if ($request->customerStatusId) {
            $comunication = Comunications::find($idComunication);

            $customer = Customers::find($comunication->customer_id);
            $customer->id_status = $request->customerStatusId;
            $customer->save();
        }

        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();

        if ($request->customerStatusId == 18) { //Estado = Interesado

            $assignment = Assignment::where('customer_id', $comunication->customer_id)
                                        ->where('status', 1)
                                        ->first();

            if ($assignment) {
                $assignment->status = 0;
                $assignment->save();
            }


            try {
                $assignament = new Assignment();
                $assignament->agent_id = $agent->id;
                $assignament->customer_id = $comunication->customer_id;
                $assignament->date = Carbon::now();
                $assignament->assignated_by_id = $user_id;
                $assignament->status = 1;
                $assignament->save();
            } catch (Exception $e) {
                echo($e->getMessage());
            }

        }

        if ($request->customerStatusId == 17) { //Estado = NA
            $customer = Customers::find($comunication->customer_id);
            $customer->call_black = true;
            $customer->save();
        }

        $countClientesNA = Customers::where('status', '!=', 17)
                                    ->where('folder_id', 6)
                                    ->count();

        if ($countClientesNA == 0) {
            $folder = Folder::find(6);
            $folder->status = false;
            $folder->save();
        }

        $data = $this->comentarioService->updateComunication($dataCustomer);
        $customers = $this->clientService->index();
        return response()->json(["view"=>view('cliente.list.listCustomer', $customers)->render(), "title"=>$data['title'], "text"=>$data['mensaje'], "status"=>$data['status']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
