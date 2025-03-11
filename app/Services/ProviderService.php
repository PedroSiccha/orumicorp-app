<?php
namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Interfaces\ProviderInterface;
use App\Interfaces\ProviderRepositoryInterface;
use App\Interfaces\RolRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            $providers = $this->providerRepository->getProvidersByCustomer($request->customer_id);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $providers]);
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
            // Obtener el rol de proveedor
            $role = $this->rolRepository->findById(9);
            if (!$role) {
                return ResponseHelper::error('Rol de proveedor no encontrado.');
            }

            // Crear usuario para el proveedor
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->email) // Se asegura de encriptar la contraseña
            ];

            $user = $this->userRepository->createUser($userData);
            if (!$user) {
                DB::rollBack();
                return ResponseHelper::error('Error al crear el usuario para el proveedor.');
            }

            // Crear el proveedor
            $dataProvider = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'user_id' => $user->id
            ];

            $provider = $this->providerRepository->save($dataProvider);
            if (!$provider) {
                DB::rollBack();
                return ResponseHelper::error('Error al registrar el proveedor.');
            }

            // Confirmar transacción
            DB::commit();

            // Obtener proveedores actualizados
            $suppliers = $this->providerRepository->getAll();

            return ResponseHelper::success('Proveedor registrado correctamente.', ['providers' => $suppliers]);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en saveProvider: " . $e->getMessage());
            return ResponseHelper::error('Error al registrar el proveedor.');
        }
    }


    public function updateProvider($request)
    {
        DB::beginTransaction();
        try {
            $provider = $this->providerRepository->findById($request->providerId);
            if (!$provider) {
                return ResponseHelper::error('Proveedor no encontrado.');
            }

            // Datos para actualizar el proveedor
            $dataProvider = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email
            ];

            // Actualizar el proveedor
            $updated = $this->providerRepository->update($provider, $dataProvider);
            if (!$updated) {
                DB::rollBack();
                return ResponseHelper::error('Error al actualizar el proveedor.');
            }

            // Confirmar la transacción
            DB::commit();

            // Obtener lista de proveedores actualizada
            $suppliers = $this->providerRepository->getAll();

            return ResponseHelper::success('Proveedor actualizado correctamente.', ['providers' => $suppliers]);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en updateProvider: " . $e->getMessage());
            return ResponseHelper::error('Error al actualizar el proveedor.');
        }
    }


    public function deleteProvider($request)
    {
        DB::beginTransaction();
        try {
            // Buscar el proveedor antes de eliminar
            $provider = $this->providerRepository->findById($request->providerId);
            if (!$provider) {
                return ResponseHelper::error('Proveedor no encontrado.');
            }

            // Intentar eliminar el proveedor
            $deleted = $this->providerRepository->delete($request->providerId);
            if (!$deleted) {
                DB::rollBack();
                return ResponseHelper::error('Error al eliminar el proveedor.');
            }

            // Confirmar la eliminación
            DB::commit();

            // Obtener la lista actualizada de proveedores
            $suppliers = $this->providerRepository->getAll();

            return ResponseHelper::success('Proveedor eliminado correctamente.', ['providers' => $suppliers]);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en deleteProvider: " . $e->getMessage());
            return ResponseHelper::error('Error al eliminar el proveedor.');
        }
    }

}
