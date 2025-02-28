<?php
namespace App\Services;
class PerfilService
{

    protected $perfilRepository;

    public function __construct(
        PerfilRepositoryInterface $perfilRepository
    ) {
      $this->perfilRepository = $perfilRepository;  
    }

    public function getProfileData()
    {
        // $agent = Agent::where('user_id', $id)->first();
        // $client = Customers::where('user_id', $id)->first();
        // $rouletteSpin = 0;

        // if ($agent->number_turns) {
        //     $rouletteSpin = $agent->number_turns;
        // }

        // $dataUser = null;

        // if ($agent) {
        //     $dataUser = $agent;
        // }

        // if ($client) {
        //     $dataUser = $client;
        // }

        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();

        // $dateIn = Assistance::where('date', date('Y-m-d'))->where('type', 'IN')->where('agent_id', $agent->id)->first();
        // $dateBreakIn = Assistance::where('date', date('Y-m-d'))->where('type', 'IN-BREAK')->where('agent_id', $agent->id)->first();
        // $dateBreakOut = Assistance::where('date', date('Y-m-d'))->where('type', 'OUT-BREAK')->where('agent_id', $agent->id)->first();
        // $dateOut = Assistance::where('date', date('Y-m-d'))->where('type', 'OUT')->where('agent_id', $agent->id)->first();
        // $clients = Customers::where('agent_id', $agent->id)->paginate(5, ['*'], 'clients_page')->withQueryString();
        // $targets = Target::select('id', 'amount', 'agent_id')
        //                 ->selectRaw("MONTHNAME(CONCAT('2024-', month, '-01')) AS mes")
        //                 ->where('agent_id', $agent->id  )
        //                 ->paginate(5, ['*'], 'targets_page')->withQueryString();

        // $sales = Sales::select('sales.*', 'c.name', 'c.lastname')
        //                 ->join('customers as c', 'sales.customer_id', '=', 'c.id')
        //                 ->where('sales.agent_id', $agent->id)
        //                 ->paginate(5, ['*'], 'sales_page')->withQueryString();

        // $targetMensual = Target::where('status', true)
        //                 ->where('month', date("m"))
        //                 ->where('agent_id', $agent->id)
        //                 ->orderBy("created_at", "asc")
        //                 ->first();

        // $ingresosActuales = Sales::join('actions', 'sales.action_id', '=', 'actions.id')
        //                             ->where('actions.movement_type_id', 1)
        //                             ->where('actions.status', 1)
        //                             ->where('sales.status', 1)
        //                             ->where('sales.agent_id', $agent->id)
        //                             ->whereMonth('sales.created_at', date("m"))
        //                             ->sum('sales.amount');

        // $amountRetiro = Sales::join('actions', 'sales.action_id', '=', 'actions.id')
        //                     ->where('actions.movement_type_id', 2)
        //                     ->where('actions.status', 1)
        //                     ->where('sales.status', 1)
        //                     ->where('sales.agent_id', $agent->id)
        //                     ->whereMonth('sales.created_at', date("m"))
        //                     ->sum('sales.amount');

        // return view('profile.index', compact('premios1', 'premios2', 'dataUser', 'rouletteSpin', 'dateIn', 'dateBreakIn', 'dateBreakOut', 'dateOut', 'clients', 'targets', 'sales', 'targetMensual', 'ingresosActuales', 'amountRetiro'));
    }
}