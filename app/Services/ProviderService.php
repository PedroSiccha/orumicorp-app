<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreProviderRequest;
use App\Http\Requests\StoreUserRequest;
use App\Interfaces\ProviderInterface;
use App\Interfaces\ProviderRepositoryInterface;
use App\Interfaces\RolRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProviderService implements ProviderInterface {

    protected $providerRepository, $rolRepository, $userRepository; 

    public function __construct(
        ProviderRepositoryInterface $providerRepository,
        RolRepositoryInterface $rolRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->providerRepository = $providerRepository;
        $this->rolRepository = $rolRepository;
        $this->userRepository = $userRepository;
    }

    public function getAllProvidersByCustomer($request) {
        try {
            $providers = $this->providerRepository->getAllProvidersByCustomer($request->customer_id);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $providers]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function getLastProviderByCustomer($request) {
        try {
            $lastProvider = $this->providerRepository->getLastProviderByCustomer($request->customer_id);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $lastProvider]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function saveProvider($request)
    {
        DB::beginTransaction();
        try {
            $role = $this->rolRepository->findRoleById(9);
            $userData = new StoreUserRequest([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->email
            ]);
            $user = $this->userRepository->createUser($userData);
            $dataProvider = new StoreProviderRequest([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'user_id' => $user->id
            ]);
            $provider = $this->providerRepository->saveProvider($dataProvider);
            DB::commit();
            $suppliers = $this->providerRepository->getProviders();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $suppliers]);
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

    public function updateProvider($request)
    {
        DB::beginTransaction();
        try {
            $dataProvider = new StoreProviderRequest([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
            $provider = $this->providerRepository->findProviderById($request->providerId);
            $response = $this->providerRepository->updateProvider($provider, $dataProvider);
            DB::commit();
            $suppliers = $this->providerRepository->getProviders();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $suppliers]);
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

    public function deleteProvider($request)
    {
        try {
            $provider = $this->providerRepository->deleteProvider($request->providerId);
            $suppliers = $this->providerRepository->getProviders();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $suppliers]);
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
