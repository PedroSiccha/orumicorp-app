<?php
namespace App\Services;

use App\Http\Requests\CampaignRequest;
use App\Interfaces\CampaingInterface;
use App\Interfaces\CampaingRepositoryInterface;
use App\Models\CampaignCustomer;
use App\Models\Campaing;
use App\Models\Customers;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CampaingService /*implements CampaingInterface */{

    protected $campaingRepository;

    public function __construct(
        CampaingRepositoryInterface $campaingRepository
    ) {
        $this->campaingRepository = $campaingRepository;
    }

    public function getAllCampaingsByCustomer($request) {
        try {
            $customerId = $request['customer_id'];
            $campaings = $this->campaingRepository->getCampaing(); // Campaing::get();
            return $campaings;
        } catch (Exception $e) {
            dd($e);
            return collect();
        }

    }

    public function getLastCampaingByCustomer($request) {
        try {
            $customerId = $request['customer_id'];

            $lastCampaing = $this->campaingRepository->getLastCampaingByCustomer($customerId); 
            //  Campaing::whereHas('customers', function($query) use ($customerId) {
            //     $query->where('customer_id', $customerId);
            // })->with('customers')->orderBy('created_at', 'desc')->first();

            return response()->json([
                'status' => 'success',
                'data' => $lastCampaing,
            ]);
        } catch (Exception $e) {
            return null;
        }
    }

    public function saveCampaing($request) {

        DB::beginTransaction();
        try {
            $response = $this->campaingRepository->saveCampaing($request);
            DB::commit();

            // $campaign = new Campaing();
            // $campaign->name = $request->name;
            // $campaign->description = $request->description;
            // $campaign->start_date = $request->startDate;
            // $campaign->end_date = $request->endDate;
            // if ($campaign->save()) {
            //     $title = "Correcto";
            //     $mensaje = "Su campaña se registró correctamente";
            //     $status = "success";
            // }

        } catch (ValidationException $e) {
            DB::rollBack();
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            DB::rollBack();
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $campaigns = $this->campaingRepository->getCampaing(); // Campaing::get();
    }

    public function getAllCampaigns()
    {
        $campaigns = $this->campaingRepository->getAllCampaings();
         // Campaing::get();
    }

    public function getCampaigns()
    {
        $campaigns = $this->campaingRepository->getCampaing();
         // Campaing::get();
    }

    // public function saveCampaign(CampaignRequest $request)
    // {
    //     // $title = "Error";
    //     // $mensaje = "Error desconocido";
    //     // $status = "error";

    //     // try {

    //     //     $campaign = new Campaing();
    //     //     $campaign->name = $request->name;
    //     //     $campaign->description = $request->description;
    //     //     $campaign->start_date = $request->startDate;
    //     //     $campaign->end_date = $request->endDate;
    //     //     if ($campaign->save()) {
    //     //         $title = "Correcto";
    //     //         $mensaje = "Su campaña se registró correctamente";
    //     //         $status = "success";
    //     //     }

    //     // } catch (ValidationException $e) {
    //     //     $title = "Error";
    //     //     $mensaje = $e->getMessage();
    //     //     $status = "error";
    //     // } catch (Exception $e) {
    //     //     $title = "Error";
    //     //     $mensaje = $e->getMessage();
    //     //     $status = "error";
    //     // }

    //     // $campaigns = Campaing::get();

    //     // return response()->json(["view"=>view('campaign.table.tableCampaign', compact('campaigns'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    // }

    public function updateCampaign(CampaignRequest $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // try {
        $data = $this->campaingRepository->updateCampaign($request->id, $request);

        //     $campaign = Campaing::find($request->id);
        //     $campaign->name = $request->name;
        //     $campaign->description = $request->description;
        //     $campaign->start_date = $request->startDate;
        //     $campaign->end_date = $request->endDate;

        //     if ($campaign->save()) {
        //         $title = "Correcto";
        //         $mensaje = "Se actualizó su campaña correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "Hubo un error al actualizar su campaña";
        //         $status = "error";
        //     }

        // } catch (ValidationException $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = "Verificar los datos del registro";
        //     $status = "error";
        // }
        $campaigns = $this->campaingRepository->getCampaing();
        // $campaigns = Campaing::get();

        // return response()->json(["view"=>view('campaign.table.tableCampaign', compact('campaigns'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    public function deleteCampaign(CampaignRequest $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";
        // $campaign = Campaing::find($request->id);
        // if ($campaign == null) {
        //     $title = "Error";
        //     $mensaje = "Hubo un error con su campaña";
        //     $status = "error";
        // }
        // try {
            $data = $this->campaingRepository->deleteCampaign($request->id);
        //     if ($campaign->delete()) {
        //         $title = "Correcto";
        //         $mensaje = "Su campaña se eliminó correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "No se pudo eliminar su campaña";
        //         $status = "error";
        //     }
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // }
        $campaigns = $this->campaingRepository->getCampaing();
        // $campaigns = Campaing::get();

        // return response()->json(["view"=>view('campaign.table.tableCampaign', compact('campaigns'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

}
