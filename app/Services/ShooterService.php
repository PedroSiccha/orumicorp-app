<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreShooterRequest;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\CategoryFolderRepositoryInterface;
use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\ClientStatusRepositoryInterface;
use App\Interfaces\ComunicationRepositoryInterface;
use App\Interfaces\FolderRepositoryInterface;
use App\Interfaces\ShooterRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ShooterService
{

    protected $shooterRepository, $userRepository, $agentRepository, $clientRepository, $clientStatusRepository, $folderRepository, $categoryFolderRepository, $comunicationRepository;

    public function __construct(
        ShooterRepositoryInterface $shooterRepository,
        UserRepositoryInterface $userRepository,
        AgentRepositoryInterface $agentRepository,
        ClientRepositoryInterface $clientRepository,
        ClientStatusRepositoryInterface $clientStatusRepository,
        FolderRepositoryInterface $folderRepository,
        CategoryFolderRepositoryInterface $categoryFolderRepository,
        ComunicationRepositoryInterface $comunicationRepository
    ) {
      $this->shooterRepository = $shooterRepository;  
      $this->userRepository = $userRepository;  
      $this->agentRepository = $agentRepository;  
      $this->clientRepository = $clientRepository;  
      $this->clientStatusRepository = $clientStatusRepository;  
      $this->folderRepository = $folderRepository;  
      $this->categoryFolderRepository = $categoryFolderRepository;  
      $this->comunicationRepository = $comunicationRepository;  
    }

    public function getShooterData()
    {
        try {
            $user = $this->userRepository->getUser();
            $roles = $user->getRoleNames()->first();
            $agent = $this->agentRepository->getMyAgent();
            $rouletteSpin = $agent->number_turns ?: 0;
            $clients = $this->clientRepository->getClientsByStatus(1);
            $shooter = $this->shooterRepository->getShooter();
            $na = $this->clientStatusRepository->findStatusByName('NA'); 
            $na_1 = $this->clientStatusRepository->findStatusByName('NA 1');
            $na_2 = $this->clientStatusRepository->findStatusByName('NA 2');
            $na_3 = $this->clientStatusRepository->findStatusByName('NA 3');
            if ($shooter) {
                $clients = $this->clientRepository->getClientsByFolderExceptStatus($shooter->folder_id, [$na->id, $na_1->id, $na_2->id, $na_3->id]);
            }
            $folders = $this->folderRepository->getFolders();
            $statusCustomers = $this->clientStatusRepository->getCustomerStatus();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $statusCustomers]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function getShooterAdmin()
    {
        try {
            $user = $this->userRepository->getUser();
            $roles = $user->getRoleNames()->first();
            $agent = $this->agentRepository->getMyAgent();
            $rouletteSpin = $agent->number_turns ?: 0;
            $categoryFolders = $this->categoryFolderRepository->getCategoryFolders();
            $folders = $this->folderRepository->getFoldersByCategory(1);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $folders]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }        
    }

    public function getFolderData(int $categoryId)
    {
        try {
            $folders = $this->folderRepository->getFoldersByCategory($categoryId);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $folders]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function getClientsByFolder(int $folderId)
    {
        try {
            $clients = $this->clientRepository->getClientsByFolder($folderId);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $clients]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function getResumClient(int $clientId)
    {
        try {
            $comunications = $this->comunicationRepository->getComunicationsByClient($clientId);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $comunications]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function activeShooter($request)
    {
        try {
            $folder = $this->folderRepository->findFolderById($request->folder_id);
            $dataShooter = new StoreShooterRequest([
                'name' => $request->name,
                'status' => StatusEnum::ACTIVE->value,
                'start' => Carbon::now(),
                'folder_id' => $folder->id
            ]);
            $response = $this->shooterRepository->saveShooter($dataShooter);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.');
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function disableShooter(int $shooterId)
    {
        try {
            $shooter = $this->shooterRepository->findShooterById($shooterId);
            $response = $this->shooterRepository->disableShooter($shooter);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.');
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function notiffyShooter(Request $request)
    {
        try {
            $user = $this->userRepository->getUser();
            $agent = $this->agentRepository->getAgentByUserId($user->id);
            $shooter = $this->shooterRepository->getShooter();
            if ($shooter) {
                $clients = $this->clientRepository->getClientsByFolder($request->folderId);
                if ($clients->isNotEmpty()) {
                    $randomClient = $clients->random();
                    $message = "Llamada activa con " . $randomClient->name;
                    $phone = $randomClient->phone;
                    $type = "info";
                    $shooter = "1";
                }
            }
            return ResponseHelper::success('Se cambió el estado del agente correctamente.');
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

}