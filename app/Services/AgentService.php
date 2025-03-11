<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Enums\StatusVoiso;
use App\Helpers\ResponseHelper;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\AreaRepositoryInterface;
use App\Interfaces\RolesInterface;
use App\Interfaces\RolRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AgentService {

    protected $utils;
    protected $rolesService;
    protected $agentRepository;
    protected $areaRepository;
    protected $rolesRepository;
    protected $userRepository;

    public function __construct(
        Utils $utils,
        RolesInterface $rolesService,
        AgentRepositoryInterface $agentRepository,
        AreaRepositoryInterface $areaRepository,
        RolRepositoryInterface $rolesRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->utils = $utils;
        $this->rolesService = $rolesService;
        $this->agentRepository = $agentRepository;
        $this->areaRepository = $areaRepository;
        $this->rolesRepository = $rolesRepository;
        $this->userRepository = $userRepository;
    }

    public function getAgentsData()
    {
        try {
            return ResponseHelper::success('Datos obtenidos correctamente.', [
                'agents' => $this->agentRepository->paginate(10),
                'areas' => $this->areaRepository->getAllActive(),
                'roles' => $this->rolesRepository->getAll()
            ]);
        } catch (Exception $e) {
            Log::error("Error en getAgentsData: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener datos de agentes.');
        }
    }

    public function searchAgent(string $code)
    {
        try {
            $agent = $this->agentRepository->getByCode($code);
            return $agent
                ? ResponseHelper::success('Agente encontrado.', ['name' => "{$agent->name} {$agent->lastname}"])
                : ResponseHelper::error('El agente no existe.');
        } catch (Exception $e) {
            Log::error("Error en searchAgent: " . $e->getMessage());
            return ResponseHelper::error('Error al buscar el agente.');
        }
    }

    public function saveAgent(array $data)
    {
        DB::beginTransaction();
        try {
            $role = $this->rolesRepository->findById($data['rol_id']);
            if (!$role) return ResponseHelper::error('El rol no existe.');

            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ];
            $user = $this->userRepository->createUser($userData);
            $user->assignRole($role);

            $agentData = [
                'code' => $data['code'],
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'code_voiso' => $data['codeVoiso'],
                'status' => StatusEnum::ACTIVE->value,
                'number_turns' => $data['numberTurns'],
                'img' => $data['img'],
                'status_voiso' => StatusVoiso::LIBRE->value,
                'area_id' => $data['area_id'],
                'user_id' => $user->id
            ];
            $this->agentRepository->save($agentData);

            DB::commit();
            return ResponseHelper::success('Agente guardado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en saveAgent: " . $e->getMessage());
            return ResponseHelper::error('Error al guardar el agente.');
        }
    }

    public function updateAgent(array $data)
    {
        DB::beginTransaction();
        try {
            $agent = $this->agentRepository->getById($data['id']);
            if (!$agent) return ResponseHelper::error('El agente no existe.');

            $user = $this->userRepository->findUserById($agent->user_id);
            if (!$user) return ResponseHelper::error('Usuario no encontrado.');

            $role = $this->rolesRepository->findById($data['rol_id']);
            $user->assignRole($role);

            $this->agentRepository->update($agent, $data);
            $this->userRepository->updateUser($user, ['name' => $data['name'], 'password' => $data['password']]);

            DB::commit();
            return ResponseHelper::success('Agente actualizado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en updateAgent: " . $e->getMessage());
            return ResponseHelper::error('Error al actualizar el agente.');
        }
    }

    public function changeAgentStatus($agentId, $status)
    {
        try {
            $agent = $this->agentRepository->getById($agentId);
            return $agent
                ? ResponseHelper::success('Estado cambiado.', ['response' => $this->agentRepository->changeStatus($agent->id, $status)])
                : ResponseHelper::error('Agente no encontrado.');
        } catch (Exception $e) {
            Log::error("Error en changeAgentStatus: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar estado.');
        }
    }

    public function deleteAgent($agentId)
    {
        DB::beginTransaction();
        try {
            $agent = $this->agentRepository->getById($agentId);
            if (!$agent) return ResponseHelper::error('El agente no existe.');

            $user = $this->userRepository->findUserById($agent->user_id);
            if (!$user) return ResponseHelper::error('Usuario no encontrado.');

            $this->agentRepository->delete($agent->id);
            $this->userRepository->deleteUser($user->id);

            DB::commit();
            return ResponseHelper::success('Agente eliminado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en deleteAgent: " . $e->getMessage());
            return ResponseHelper::error('Error al eliminar el agente.');
        }
    }

    public function saveNumberTurns(int $agentId, int $cantidad)
    {
        try {
            $agent = $this->agentRepository->getById($agentId);
            if (!$agent) return ResponseHelper::error('El agente no existe.');

            $response = $this->agentRepository->updateTurns($agent->id, $cantidad);
            return ResponseHelper::success('Número de turnos guardado correctamente.', ['response' => $response]);
        } catch (Exception $e) {
            Log::error("Error en saveNumberTurns: " . $e->getMessage());
            return ResponseHelper::error('Error al guardar el número de turnos.');
        }
    }

    public function uploadImage($request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validator->fails()) return ResponseHelper::error($validator->errors());

            $agent = $this->agentRepository->getByUserId($request->user_id);
            if (!$agent) return ResponseHelper::error('Agente no encontrado.');

            $image = $request->file('image');
            $filePath = 'img/perfil/' . $image->getClientOriginalName();
            Storage::disk('perfil')->put($filePath, File::get($image));

            $this->agentRepository->saveAgentImage($agent->id, $filePath);
            return ResponseHelper::success('Imagen subida correctamente.');
        } catch (Exception $e) {
            Log::error("Error en uploadImage: " . $e->getMessage());
            return ResponseHelper::error('Error al subir la imagen.');
        }
    }

    public function changePassword(string $newPassword)
    {
        try {
            $user = $this->userRepository->findUserById(Auth::id());
            if (!$user) return ResponseHelper::error('El usuario no existe.');

            $hashedPassword = Hash::make($newPassword);
            $response = $this->userRepository->changePassword($user, $hashedPassword);

            return ResponseHelper::success('Contraseña cambiada correctamente.', ['response' => $response]);
        } catch (Exception $e) {
            Log::error("Error en changePassword: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar la contraseña.');
        }
    }

    public function filterAgent(array $filters)
    {
        try {
            $agents = $this->agentRepository->filter($filters, 5);
            return ResponseHelper::success('Agentes filtrados correctamente.', ['agents' => $agents]);
        } catch (Exception $e) {
            Log::error("Error en filterAgent: " . $e->getMessage());
            return ResponseHelper::error('Error al filtrar los agentes.');
        }
    }

    public function getAgent()
    {
        try {
            $agent = $this->agentRepository->getByUserId(Auth::id());
            if (!$agent) return ResponseHelper::error('No se encontró el agente.');

            return ResponseHelper::success('Agente obtenido correctamente.', ['agent' => $agent]);
        } catch (Exception $e) {
            Log::error("Error en getAgent: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener el agente.');
        }
    }

    public function saveTurn(int $agentId)
    {
        try {
            $agent = $this->agentRepository->getById($agentId);
            if (!$agent) return ResponseHelper::error('El agente no existe.');

            $newTurns = max(0, $agent->number_turns - 1); // Evita números negativos
            $this->agentRepository->updateTurns($agent->id, $newTurns);

            return ResponseHelper::success('Turno actualizado correctamente.', ['turns' => $newTurns]);
        } catch (Exception $e) {
            Log::error("Error en saveTurn: " . $e->getMessage());
            return ResponseHelper::error('Error al actualizar el turno.');
        }
    }
}
