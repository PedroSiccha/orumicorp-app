<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\CampaingRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\ClientStatusRepositoryInterface;
use App\Interfaces\FolderRepositoryInterface;
use App\Interfaces\ProviderRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FolderService
{

    protected $folderRepository, $rolesService, $userRepository, $clientRepository, $agentRepository, $campaingRepository, $providerRepository, $statusCustomerRepository;

    public function __construct(
        FolderRepositoryInterface $folderRepository,
        RolesService $rolesService,
        UserRepositoryInterface $userRepository,
        ClientRepositoryInterface $clientRepository,
        AgentRepositoryInterface $agentRepository,
        CampaingRepositoryInterface $campaingRepository,
        ProviderRepositoryInterface $providerRepository,
        ClientStatusRepositoryInterface $statusCustomerRepository
    ) {
      $this->folderRepository = $folderRepository;  
      $this->rolesService = $rolesService;
      $this->userRepository = $userRepository;
      $this->clientRepository = $clientRepository;
      $this->agentRepository = $agentRepository;
      $this->campaingRepository = $campaingRepository;
      $this->providerRepository = $providerRepository;
      $this->statusCustomerRepository = $statusCustomerRepository;
    }

    public function deleteFolder(int $folderId)
    {
        DB::beginTransaction();
        try {
            $folder = $this->folderRepository->findById($folderId);
            if (!$folder) {
                return ResponseHelper::error('La carpeta no existe.');
            }

            $this->folderRepository->disableFolder($folder);
            DB::commit();

            return ResponseHelper::success('Carpeta eliminada correctamente.', [
                'folders' => $this->folderRepository->getFoldersByCategory(1)
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en deleteFolder: " . $e->getMessage());
            return ResponseHelper::error('Error al eliminar la carpeta.');
        }
    }

    public function addGroupClientFolder(int $folderId, array $clientIds, int $limit)
    {
        DB::beginTransaction();
        try {
            $this->folderRepository->assignClientsToFolder($folderId, $clientIds);
            DB::commit();

            $customers = $this->clientRepository->getAllPaginated($limit, [
                'user', 'agent', 'latestCampaign', 'latestSupplier', 'provider',
                'statusCustomer', 'platform', 'traiding', 'latestComunication',
                'latestAssignamet', 'latestDeposit'
            ]);

            return ResponseHelper::success('Clientes asignados a la carpeta correctamente.', ['customers' => $customers]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en addGroupClientFolder: " . $e->getMessage());
            return ResponseHelper::error('Error al asignar clientes a la carpeta.');
        }
    }

    public function saveFolder(array $data)
    {
        DB::beginTransaction();
        try {
            $folder = $this->folderRepository->save([
                'name' => $data['name'],
                'status' => StatusEnum::ACTIVE->value,
                'category_id' => $data['categoryId']
            ]);

            DB::commit();

            return ResponseHelper::success('Carpeta creada correctamente.', ['folders' => $this->folderRepository->getFoldersByCategory(1)]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en saveFolder: " . $e->getMessage());
            return ResponseHelper::error('Error al crear la carpeta.');
        }
    }

    public function addClientFolder(array $data)
    {
        try {
            $customer = $this->clientRepository->getClientByCode($data['codeClient']);
            if (!$customer) {
                return ResponseHelper::error("El cliente con código '{$data['codeClient']}' no existe.");
            }

            $this->clientRepository->changeFolderClient($customer, ['folder_id' => $data['folderId']]);

            $clients = $this->clientRepository->getClientsByFolder($data['folderId']);

            return ResponseHelper::success('Cliente asignado a la carpeta correctamente.', ['clients' => $clients]);
        } catch (Exception $e) {
            Log::error("Error en addClientFolder: " . $e->getMessage());
            return ResponseHelper::error('Error al asignar el cliente a la carpeta.');
        }
    }

    public function moveFolder(int $folderId, int $categoryId)
    {
        try {
            $folder = $this->folderRepository->findById($folderId);
            if (!$folder) {
                return ResponseHelper::error('La carpeta no existe.');
            }

            $this->folderRepository->changeFolderCategory($folderId, $categoryId);

            return ResponseHelper::success('Carpeta movida correctamente.', ['folders' => $this->folderRepository->getActiveFolders()]);
        } catch (Exception $e) {
            Log::error("Error en moveFolder: " . $e->getMessage());
            return ResponseHelper::error('Error al mover la carpeta.');
        }
    }

    public function editFolder(int $folderId, array $data)
    {
        try {
            $folder = $this->folderRepository->findById($folderId);
            if (!$folder) {
                return ResponseHelper::error('La carpeta no existe.');
            }

            $this->folderRepository->update($folder, [
                'name' => $data['name'],
                'category_id' => $folder->category_id
            ]);

            return ResponseHelper::success('Carpeta actualizada correctamente.', ['folders' => $this->folderRepository->getActiveFolders()]);
        } catch (Exception $e) {
            Log::error("Error en editFolder: " . $e->getMessage());
            return ResponseHelper::error('Error al actualizar la carpeta.');
        }
    }

    public function changeFolderClient(array $data)
    {
        DB::beginTransaction();
        try {
            // Buscar cliente en la base de datos usando el repositorio
            $customer = $this->clientRepository->findById($data['clienteId']);

            if (!$customer) {
                return ResponseHelper::error('Cliente no encontrado.');
            }

            // Actualizar el folder del cliente
            $this->clientRepository->changeFolderClient($customer, ['folder_id' => $data['folderId']]);

            DB::commit();

            // Obtener el usuario y su rol
            $user_id = $this->userRepository->getMyUserId();
            $myRoles = $this->rolesService->getMyRoles();
            $agent = $this->agentRepository->getByUserId($user_id);

            // Obtener clientes según el rol
            $relations = [
                'user', 'agent', 'latestCampaign', 'latestSupplier', 'provider',
                'statusCustomer', 'platform', 'traiding', 'latestComunication',
                'latestAssignamet', 'latestDeposit'
            ];

            $customers = ($myRoles['roles'] == 'ADMINISTRADOR')
                ? $this->clientRepository->getAllPaginated(10, $relations)
                : $this->clientRepository->getByAgentPaginated($agent->id, 10, $relations);

            // Obtener datos adicionales
            $agents = $this->agentRepository->allActive();
            $campaings = $this->campaingRepository->getActiveCampaigns();
            $providers = $this->providerRepository->getAll();
            $statusCustomers = $this->clientRepository->getCustomerStatus();

            return ResponseHelper::success('Cliente asignado a la carpeta correctamente.', [
                'customers' => $customers,
                'agents' => $agents,
                'campaings' => $campaings,
                'providers' => $providers,
                'statusCustomers' => $statusCustomers
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en changeFolderClient: " . $e->getMessage());
            return ResponseHelper::error('Error al asignar el cliente a la carpeta.');
        }
    }



} 