<?php
namespace App\Services;

use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ViewsRepositoryInterface;
use Illuminate\Http\Request;

class ViewsService
{

    protected $viewsRepository;
    protected $userRepository;
    protected $agentRepository;

    public function __construct(
        ViewsRepositoryInterface $viewsRepository,
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository
    ) {
      $this->viewsRepository = $viewsRepository;
      $this->userRepository = $userRepository;
      $this->agentRepository = $agentRepository;
    }

    public function saveViews(StoreViewRequest $request)
    {
        $user_id = $this->userRepository->getMyId();
        // $agent = Agent::where('user_id', $user_id)->first();
        $agent = $this->agentRepository->getAgentByUserId($user_id);
        // $agent_id = $agent->id;
        // $client_id = $request->id;
        $view = $this->viewsRepository->saveViews($request);

        // try {
        //     $views = new Views();
        //     $views->agent_id = $agent_id;
        //     $views->customer_id = $client_id;
        //     $views->viewed_at = Carbon::now();
        //     if ($views->save()) {
        //         echo('Vista Ok');
        //     }
        // } catch (Exception $e) {
        //     echo($e->getMessage());
        // }
    }

    public function getViews(Request $request)
    {
        $data = $this->viewsRepository->getViewsByClients($request->client_id);
        // $client_id = $request->client_id;
        // $vistas = Views::with('agent')
        //                 ->where('customer_id', $client_id)
        //                 ->get();
    }
}