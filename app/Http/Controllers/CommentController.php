<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\ClientInterface;
use App\Interfaces\ComunicationInterface;
use App\Models\Agent;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\User;
use Carbon\Carbon;
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

    public function whatsapp()
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

        $response = Http::withToken($token)->get("{$baseUrl}/contacts?page=1");

        if ($response->successful()) {
            $contacts = $response->json()['contacts'];

            foreach ($contacts as &$contact) {
                if (isset($contact['createdAt'])) {
                    $contact['createdAt'] = Carbon::parse($contact['createdAt'])->format('d/m/Y');
                }
                if (isset($contact['closedAt'])) {
                    $contact['closedAt'] = Carbon::parse($contact['closedAt'])->format('d/m/Y');
                }
            }

            // dd($contacts);
            // return view('contacts.index', compact('contacts'));
            return view('whatsapp.index', compact('premios1', 'premios2', 'rouletteSpin', 'dataUser', 'contacts'));
        } else {
            return abort(500, 'Error al obtener los contactos');
        }

        return view('whatsapp.index', compact('premios1', 'premios2', 'rouletteSpin', 'dataUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveComentario(Request $request)
    {
        $dataCustomer = [
            'comunicationId' => $request->idComunication,
            'comment' => $request->txtComentario
        ];

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
