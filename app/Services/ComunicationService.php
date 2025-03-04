<?php
namespace App\Services;

use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\ClientStatusRepositoryInterface;
use App\Interfaces\ComunicationInterface;
use App\Interfaces\ComunicationRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Agent;
use App\Models\Comunications;
use App\Models\CustomerStatus;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ComunicationService /*implements ComunicationInterface */{

    protected $userRepository, $agentRepository, $comunicationRepository, $customerStatusRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository,
        ComunicationRepositoryInterface $comunicationRepository,
        ClientStatusRepositoryInterface $customerStatusRepository
    ) {
        $this->userRepository = $userRepository;
        $this->agentRepository = $agentRepository;
        $this->comunicationRepository = $comunicationRepository;
        $this->customerStatusRepository = $customerStatusRepository;
    }

    public function saveComunication(StoreComunicationRequest $request) {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $data = "";

        try {
            // $user_id = Auth::user()->id;
            $user = $this->userRepository->findUser();
            $agent = $this->agentRepository->getAgentByUserId($user->id); // Agent::where('user_id', $user_id)->first();

            $comunication = $this->comunicationRepository->saveComunication($request);
            // $comunication = new Comunications();
            // $comunication->agent_id = $agent->id;
            // $comunication->tipo = 'Llamada';
            // $comunication->customer_id = $request['customer_id'];
            // $comunication->date = Carbon::now();
            // $comunication->descripcion = $request['description'];
            // $comunication->comment = $request['comment'];
            // $comunication->status = "NUEVO";
            // if ($comunication->save()) {
            //     $title = "Correcto";
            //     $mensaje = "Comunication Success";
            //     $status = "success";
            //     $data = $comunication->id;
            // }

        } catch (\Throwable $th) {
            $title = "Error";
            $mensaje = $th->getMessage();
            $status = "error";
            $data = "";
        }
        return ['title' => $title, 'mensaje' => $mensaje, 'status' => $status, 'data' => $data];
    }

    public function updateComunication(EditComunicationRequest $request) {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $statusCustomer_id = $request['customerStatusId'];
        $statusCommunicationName = "";

        if ($statusCustomer_id) {
            $statusCommunication = $this->customerStatusRepository->updateCustomerStatus($request);
            // $statusCommunication = CustomerStatus::find($request['customerStatusId']);
            // $statusCommunicationName = $statusCommunication->name;
        }

        try {

            // $user_id = Auth::user()->id;
            $user = $this->userRepository->findUser();
            $agent = $this->agentRepository->getAgentByUserId($user->id); // Agent::where('user_id', $user_id)->first();

            $comunication = $this->comunicationRepository->updateComunication($request);
            // $comunication = Comunications::find($request['comunicationId']);
            // $comunication->comment = $request['comment'];
            // $comunication->status = $statusCommunicationName;

            // if ($comunication->save()) {
            //     $title = "Correcto";
            //     $mensaje = "Comunication Update";
            //     $status = "success";
            // }

        } catch (ValidationException $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Verificar los datos del registro";
            $status = "error";
        }

        return [
            'title' => $title,
            'mensaje' => $mensaje,
            'status' => $status
        ];
    }

    public function getLocationByAgent($request) {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $data = [];

        try {
            $communication = $this->comunicationRepository->getComunicationsByAgent($request['agent_id']);
            $title = "Correcto";
            $mensaje = "Lista de Communication";
            $status = "success";
            $data = $communication;
        } catch (\Throwable $th) {
            $title = "Error";
            $mensaje = $th->getMessage();
            $status = "error";
            $data = [];
        }
        return [
            'title' => $title,
            'mensaje' => $mensaje,
            'status' => $status,
            'data' => $data
        ];
    }

    public function getLocationByCustomer($request) {
        try {
            $communications = $this->comunicationRepository->getComunicationsbyCustomer($request['customer_id']);
            

            return $communications;
        } catch (\Exception $e) {
            return collect();
        }
    }

}
