<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Enums\StatusVoiso;
use App\Helpers\ResponseHelper;
use App\Http\Requests\EditAgentRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\StoreUserRequest;
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
    protected $userRepositoy;

    public function __construct(
        Utils $utils,
        RolesInterface $rolesService,
        AgentRepositoryInterface $agentRepository,
        AreaRepositoryInterface $areaRepository,
        RolRepositoryInterface $rolesRepository,
        UserRepositoryInterface $userRepositoy
    ) {
        $this->utils = $utils;
        $this->rolesService = $rolesService;
        $this->agentRepository = $agentRepository;
        $this->areaRepository = $areaRepository;
        $this->rolesRepository = $rolesRepository;
        $this->userRepositoy = $userRepositoy;
    }

    public function getAgentsData() {
        try {
            $agents = $this->agentRepository->getAllAgentsPaginated(10);
            $areas = $this->areaRepository->getAreas();
            $roles = $this->rolesRepository->getAllRoles();

            $response = [
                'agents' => $agents,
                'areas' => $areas,
                'roles' => $roles
            ];

            return ResponseHelper::success('Datos obtenido correctamente.', ['response' => $response]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Ocurrió un error inesperado al obtener los datos del cliente.');
        }
    }

    public function searchAgent(string $code)
    {
        try {
            $agent = $this->agentRepository->findAgentByCode($code);
            if (!$agent) {
                return ResponseHelper::error('El agente no existe.');
            }

            return ResponseHelper::success('Agente encontrado exitosamente.', ['name' => "{$agent->name} {$agent->lastname}"]);

        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error no se pudo encontrar el agente.');
        }

    }

    public function saveAgent (array $data)
    {
        DB::beginTransaction();
        try {
            $role = $this->rolesRepository->findRoleById($data['rol_id']);
            if (!$role) {
                return ResponseHelper::error('El rol proporcionado no existe.');
            }

            $dataUser = new StoreUserRequest([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);

            $user = $this->userRepositoy->createUser($dataUser);
            $user->assignRole($role);
            $dataAgent = new StoreAgentRequest([
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
            ]);
            $agent = $this->agentRepository->saveAgent($dataAgent);
            DB::commit();
            return ResponseHelper::success('Se guardó el agente correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al guardar el agente.');
        }
    }

    public function updateAgent($requestData) 
    {
        DB::beginTransaction();
        try {
            $agent = $this->agentRepository->findAgentById($requestData->id);
            $role = $this->rolesRepository->findRoleById($requestData['rol_id']);
            if (!$agent) {
                return ResponseHelper::error('El agente no existe.');
            }
            $user = $this->userRepositoy->findUserById($agent->user_id);
            if (!$user) {
                return ResponseHelper::error('El usuario asociado al agente no existe.');
            }
            $user->assignRole($role);

            $dataAgent = new EditAgentRequest([
                'name' => $requestData->name,
                'lastname' => $requestData->lastname,
                'code_voiso' => $requestData->codeVoiso,
                'status' => $requestData->status,
                'number_turns' => $requestData->numberTurns,
                'img' => $requestData->img,
                'area_id' => $requestData->area_id,
            ]);

            $dataUser = new EditUserRequest([
                'name' => $requestData->name,
                'password' => $requestData->password
            ]);

            $this->agentRepository->updateAgent($agent, $dataAgent);
            $this->userRepositoy->updateUser($user, $dataUser);

            DB::commit();
            return ResponseHelper::success('Se actualizó el agente correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::success('Error al actualizar el agente.');
        }
    }

    public function cambiarEstadoAgente($agentId, $status) {
        try {
            $agent = $this->agentRepository->findAgentById($agentId);
            if (!$agent) {
                return ResponseHelper::error('El agente no existe.');
            }
            $response = $this->agentRepository->changeAgentStatus($agent, $status);
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $response]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function eliminarAgente($agentId) {
        DB::beginTransaction();
        try {
            $agent = $this->agentRepository->findAgentById($agentId);
            if (!$agent) {
                return ResponseHelper::error('El agente no existe.');
            }
            $user = $this->userRepositoy->findUserById($agent->user_id);
            if (!$user) {
                return ResponseHelper::error('El usuario asociado al agente no existe.');
            }
            $this->agentRepository->deleteAgent($agent->id);
            $this->userRepositoy->deleteUser($user->agent);
            DB::commit();
            return ResponseHelper::success('Se eliminó el agente correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al eliminar el agente.');
        }
    }

    public function saveNumberTurns($agentId, $cantidad) {
        try {
            $agent = $this->agentRepository->findAgentById($agentId);
            if (!$agent) {
                return ResponseHelper::error('El agente no existe.');
            }
            $response = $this->agentRepository->saveNumberTurns($agent, $cantidad);
            return ResponseHelper::success('Se guardó el número de turnos correctamente.', ['response' => $response]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al guardar el número de turnos.');
        }
    }

    public function uploadImg($request) {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return ResponseHelper::error($validator->errors());
            }
            $agent = $this->agentRepository->getAgentByUserId($request->user_id);
            
            $dataImg = $request->image;
            $subido = "";
            $urlGuardar = "";
            if ($request->hasFile('image')) {
                $nombre = $dataImg->getClientOriginalName();
                $extension = $dataImg->getClientOriginalExtension();
                $nuevoNombre = $nombre . "." . $extension;
                $subido = Storage::disk('perfil')->put($nombre, File::get($dataImg));
                if ($subido) {
                    $urlGuardar = 'img/perfil/' . $nombre;
                }
            }
            $response = $this->agentRepository->saveAgentImage($agent, $urlGuardar);
            return ResponseHelper::success('Se guardó el número de turnos correctamente.', ['response' => $response]);
            
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Hubo un error al guardar la imagen.');
        }
    }

    public function changePassword($request) {
        try {
            $user = $this->userRepositoy->findUserById(Auth::user()->id);
            if (!$user) {
                return ResponseHelper::error('El usuario no existe.');
            }
            $response = $this->userRepositoy->changePassword($user, $request);
            return ResponseHelper::success('Se cambió la contraseña correctamente.', ['response' => $response]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar la contraseña.');
        }
    }

    public function filterAgent($request)
    {
        try {
            $agents = $this->agentRepository->filterAgent($request);
            return ResponseHelper::success('Se filtraron los agentes correctamente.', ['agents' => $agents]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al filtrar los agentes.');
        }
    }

    public function getAgent()
    {
        try {
            $agent = $this->agentRepository->getAgentByUserId(Auth::user()->id);
            return ResponseHelper::success('Se obtuvo el agente correctamente.', ['agent' => $agent]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener el agente.');
        }
    }

    public function saveTurn($request)
    {
        try {
            $agent = $this->agentRepository->getMyAgent();
            $cant_giro = $agent->number_turns;
            $new_giro = 0;
            if ($cant_giro > 0) {
                $new_giro = $cant_giro - 1;
            }
            $this->agentRepository->saveNumberTurns($agent, $new_giro);
            return ResponseHelper::success('Se obtuvo el agente correctamente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener el agente.');
        }
        
    }
}
