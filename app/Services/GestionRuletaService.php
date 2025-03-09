<?php
namespace App\Services;

use App\Http\Requests\PrizeRequest;
use App\Interfaces\GestionRuletaRepositoryInterface;

class GestionRuletaService
{

    protected $gestionRuletaRepository;

    public function __construct(
        GestionRuletaRepositoryInterface $gestionRuletaRepository
    ) {
        $this->gestionRuletaRepository = $gestionRuletaRepository;        
    }
    
    public function savePrize($request)
    {
        
        // $resp = 0;
        // $type = 1;

        // if ($request->orden < 5) {
        //     $type = 1;
        // } else {
        //     $type = 2;
        // }


        // $premios = Premio::where('order', $request->orden)->first();
        // $premios->name = $request->nombre;
        // $premios->description = $request->descripcion;
        // $premios->value = $request->valor;
        // $premios->status = 1;
        // $premios->order = $request->orden;
        // $premios->type = $type;
        // if ($premios->save()) {
        //     $resp = 1;
        // }

        // $premios = Premio::where('status', true)->get();

        // return response()->json(["view"=>view('gestionRuleta.components.tabPremio', compact('premios'))->render(), "resp"=>$resp]);
    }
}