<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Interfaces\ClientStatusRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            $customerStatus = $this->customerStatusRepository->getAll();
            return ResponseHelper::success('Lista de estados de clientes obtenida correctamente.', ['customerStatus' => $customerStatus]);
        } catch (Exception $e) {
            Log::error("Error en getCustomerStatus: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener los estados de clientes.');
        }
    }

    public function saveCustomerStatus(array $data)
    {
        DB::beginTransaction();
        try {
            $customerStatus = $this->customerStatusRepository->save([
                'name' => $data['name'],
                'color' => 'table-default',
                'description' => $data['description'] ?? null
            ]);

            DB::commit();
            return ResponseHelper::success('Estado de cliente guardado correctamente.', ['customerStatus' => $customerStatus]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en saveCustomerStatus: " . $e->getMessage());
            return ResponseHelper::error('Error al guardar el estado del cliente.');
        }
    }

    public function updateCustomerStatus(array $data)
    {
        DB::beginTransaction();
        try {
            $customerStatus = $this->customerStatusRepository->findById($data['customerStatusId']);

            if (!$customerStatus) {
                return ResponseHelper::error('El estado del cliente no existe.');
            }

            $updatedStatus = $this->customerStatusRepository->update($customerStatus, [
                'name' => $data['name'],
                'color' => 'table-default',
                'description' => $data['description'] ?? null
            ]);

            DB::commit();
            return ResponseHelper::success('Estado del cliente actualizado correctamente.', ['customerStatus' => $updatedStatus]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en updateCustomerStatus: " . $e->getMessage());
            return ResponseHelper::error('Error al actualizar el estado del cliente.');
        }
    }

    public function deleteCustomerStatus(int $customerStatusId)
    {
        DB::beginTransaction();
        try {
            $customerStatus = $this->customerStatusRepository->findById($customerStatusId);

            if (!$customerStatus) {
                return ResponseHelper::error('El estado del cliente no existe.');
            }

            $this->customerStatusRepository->delete($customerStatusId);
            DB::commit();

            return ResponseHelper::success('Estado del cliente eliminado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en deleteCustomerStatus: " . $e->getMessage());
            return ResponseHelper::error('Error al eliminar el estado del cliente.');
        }
    }
}