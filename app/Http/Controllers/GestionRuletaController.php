<?php

namespace App\Http\Controllers;

use App\Models\Premio;
use Illuminate\Http\Request;

class GestionRuletaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $premios = Premio::where('status', true)->get();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        return view('gestionRuleta.index', compact('premios', 'premios1', 'premios2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function savePremio(Request $request)
    {
        $resp = 0;

        $premios = new Premio();
        $premios->name = $request->nombre;
        $premios->description = $request->descripcion;
        $premios->value = $request->valor;
        $premios->status = 1;
        if ($premios->save()) {
            $resp = 1;
        }

        $premios = Premio::where('status', true)->get();

        return response()->json(["view"=>view('gestionRuleta.components.tabPremio', compact('premios'))->render(), "resp"=>$resp]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
