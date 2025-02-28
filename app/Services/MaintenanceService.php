<?php
namespace App\Services;
class MaintenanceService
{

    protected $maintenanceRepository;

    public function __construct(
        MaintenanceRepositoryInterface $maintenanceRepository
    ) {
        $this->maintenanceRepository = $maintenanceRepository;        
    }

    public function getMaintenanceData()
    {
        // $user_id = Auth::user()->id;
        // $user = User::where('id', $user_id)->first();
        // $roles = $user->getRoleNames()->first();
        // $agent = Agent::where('user_id', $user_id)->first();
        // $dataUser = $agent;
        // $premios1 = Premio::where('status', true)->where('type', 1)->get();
        // $premios2 = Premio::where('status', true)->where('type', 2)->get();
        // $rouletteSpin = $agent->number_turns ?: 0;

        // $customerStatusController = new CustomerStatusController();
        // $customersStatus = $customerStatusController->index();

        // // $customersStatus = CustomerStatus::get();
        // $campaigns = Campaing::get();
        // $suppliers = Provider::get();
        // $platforms = Platform::get();
        // $traidings = Traiding::get();
        // $transactionsType = TransactionType::get();
        // return view('maintenance.index', compact('premios1', 'premios2', 'rouletteSpin', 'dataUser', 'customersStatus', 'campaigns', 'suppliers', 'platforms', 'traidings', 'transactionsType'));
    }
}