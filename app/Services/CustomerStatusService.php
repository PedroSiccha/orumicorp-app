<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\StoreCustomerStatusRequest;
use App\Interfaces\ClientStatusRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CustomerStatusService
{
    protected $customerStatusRepository;

    public function __construct(
        ClientStatusRepositoryInterface $customerStatusRepository
    ) {
        $this->customerStatusRepository = $customerStatusRepository;
    }

    public function getCustomerStatus() 
    {
        try {
            $customerStatus = $this->customerStatusRepository->getCustomerStatus();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $customerStatus]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function saveCustomerStatus($request)
    {
        DB::beginTransaction();
        try {
            $dataCustomerStatus = new StoreCustomerStatusRequest([
                'name' => $request->name,
                'color' => 'table-default',
                'description' => $request->description
            ]);
            $response = $this->customerStatusRepository->saveCustomerStatus($dataCustomerStatus);
            DB::commit();
            $customerStatus = $this->customerStatusRepository->getCustomerStatus();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $customerStatus]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }        
    }

    public function updateCustomerStatus($request)
    {
        DB::beginTransaction();
        try {
            $customersStatus = $this->customerStatusRepository->findStatusById($request->customerId);
            $dataCustomerStatus = new StoreCustomerStatusRequest([
                'name' => $request->name,
                'color' => 'table-default',
                'description' => $request->description
            ]);
            $response = $this->customerStatusRepository->updateCustomerStatus($customersStatus, $dataCustomerStatus);
            DB::commit();
            $customerStatus = $this->customerStatusRepository->getCustomerStatus();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $customerStatus]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function deleteCustomerStatus($request)
    {
        DB::beginTransaction();
        try {
            $response = $this->customerStatusRepository->deleteCustomerStatus($request->customerStatusId);
            DB::commit();
            $customerStatus = $this->customerStatusRepository->getCustomerStatus();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $customerStatus]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}