<?php
namespace App\Services;

use App\Interfaces\ComunicationInterface;
use App\Models\Agent;
use App\Models\Comunications;
use App\Models\CustomerStatus;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ComunicationService implements ComunicationInterface {

    public function __construct()
    {}

    public function saveComunication($request) {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $data = "";

        try {
            $user_id = Auth::user()->id;
            $agent = Agent::where('user_id', $user_id)->first();

            $comunication = new Comunications();
            $comunication->agent_id = $agent->id;
            $comunication->tipo = 'Llamada';
            $comunication->customer_id = $request['customer_id'];
            $comunication->date = Carbon::now();
            $comunication->descripcion = $request['description'];
            $comunication->comment = $request['comment'];
            $comunication->status = "NUEVO";
            if ($comunication->save()) {
                $title = "Correcto";
                $mensaje = "Comunication Success";
                $status = "success";
                $data = $comunication->id;
            }

        } catch (\Throwable $th) {
            $title = "Error";
            $mensaje = $th->getMessage();
            $status = "error";
            $data = "";
        }
        return ['title' => $title, 'mensaje' => $mensaje, 'status' => $status, 'data' => $data];
    }

    public function updateComunication($request) {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $statusCustomer_id = $request['customerStatusId'];
        $statusCommunicationName = "";

        if ($statusCustomer_id) {
            $statusCommunication = CustomerStatus::find($request['customerStatusId']);
            $statusCommunicationName = $statusCommunication->name;
        }

        try {

            $user_id = Auth::user()->id;
            $agent = Agent::where('user_id', $user_id)->first();

            $comunication = Comunications::find($request['comunicationId']);
            $comunication->comment = $request['comment'];
            $comunication->status = $statusCommunicationName;

            if ($comunication->save()) {
                $title = "Correcto";
                $mensaje = "Comunication Update";
                $status = "success";
            }

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
            $communication = Comunications::where('agent_id', $request['agent_id'])->get();
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
            $communications = Comunications::where('customer_id', $request['customer_id'])
                ->with(['agent', 'customer'])
                ->orderBy('date', 'desc')
                ->get();

            return $communications;
        } catch (\Exception $e) {
            return collect();
        }
    }

}
