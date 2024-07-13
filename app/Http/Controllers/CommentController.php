<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\ClientInterface;
use App\Interfaces\ComunicationInterface;
use App\Models\Customers;
use Illuminate\Http\Request;

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

    public function index()
    {
        //
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
