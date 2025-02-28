<?php

namespace App\Services;

use App\DTOs\Agent\AgentIndexDTO;
use App\DTOs\Agent\AgentSearchDTO;
use App\Helpers\ResponseHelper;
use App\Http\Requests\SaveUserRequest;
use App\Interfaces\AgentInterface;
use App\Interfaces\AgentRepositoryInterface;
use App\Interfaces\AreaRepositoryInterface;
use App\Interfaces\RolesInterface;
use App\Interfaces\RolRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Customers;
use App\Models\Premio;
use App\Models\User;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
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
            $myRoles = $this->rolesService->getMyRoles();
            $user_id = Auth::user()->id;
            $agent = $this->agentRepository->getAgentByUserId($user_id);
            $rouletteSpin = $agent->number_turns ?: 0;
            $dataUser = $agent;

            $agents = $this->agentRepository->getAllAgentsPaginated(10);

            $areas = $this->areaRepository->getAllAreas();
            $roles = $this->rolesRepository->getAllRoles();

            return new AgentIndexDTO([
                'dataUser' => $dataUser,
                'rouletteSpin' => $rouletteSpin,
                'agents' => $agents,
                'areas' => $areas,
                'roles' => $roles
            ]);

        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Ocurrió un error inesperado al obtener los datos del cliente.');
        }
    }

    public function searchAgent(string $code)
    {
        try {
            $agent = $this->agentRepository->findByCodeOrVoiso($code);

            if (!$agent) {
                return ResponseHelper::error('El agente no existe.');
            }

            return new AgentSearchDTO([
                'title' => 'Éxito',
                'mensaje' => 'Agente encontrado exitosamente',
                'status' => 'success',
                'name' => "{$agent->name} {$agent->lastname}"
            ]);

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

            $dataUser = new SaveUserRequest([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
            
            $user = $this->userRepositoy->createUser($dataUser);
            $user->assignRole($role);
            $agent = $this->agentRepository->saveAgent($data);
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
            $this->agentRepository->updateAgent($agent, [
                'name' => $requestData->name,
                'lastname' => $requestData->lastname,
                'area_id' => $requestData->area_id,
                'code_voiso' => $requestData->codeVoiso
            ]);

            DB::commit();
            return ResponseHelper::success('Se actualizó el agente correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::success('Error al actualizar el agente.');
        }

        // $resp = 0;

        // $agent = Agent::find($requestData->id);
        // // $agent->code = $requestData->code;
        // $agent->name = $requestData->name;
        // $agent->lastname = $requestData->lastname;
        // $agent->area_id = $requestData->area_id;
        // $agent->code_voiso = $requestData->codeVoiso;
        // if ($agent->save()) {
        //     $user = User::find($agent->user_id);
        //     $user->name = $requestData->name;
        //     if ($user->save()) {
        //         if ($requestData->rol_id) {
        //             $role = Role::find($requestData->rol_id);
        //             $user->assignRole($role);
        //         }
        //         $resp = 1;
        //     }
        // }

        // return $resp;
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
        
        // $resp = 0;
        // $agent = Agent::find($agentId);
        // $agent->status = $status;
        // if ($agent->save()) {
        //     $resp = 1;
        // }
        // return $resp;
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

        // $resp = 0;
    
        // try {
        //     DB::transaction(function () use ($agentId, &$resp) {
        //         $agent = Agent::find($agentId);
    
        //         if (!$agent) {
        //             throw new \Exception("El agente no existe.");
        //         }
    
        //         $user = User::find($agent->user_id);
    
        //         if (!$user) {
        //             throw new \Exception("El usuario asociado al agente no existe.");
        //         }
    
        //         DB::table('notification_update')->where('user_id', $user->id)->delete();
                
        //         if ($agent->delete()) {
        //             if ($user->delete()) {
        //                 $resp = 1;
        //             }
        //         }
        //     });
    
        // } catch (Exception $e) {
        //     Log::error("Error eliminando agente: " . $e->getMessage());
        // }
    
        // return $resp;
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
        } catch (\Throwable $th) {
            //throw $th;
        }
        // $resp = 0;
        // $agent = Agent::find($agentId);
        // $agent->number_turns = $cantidad;
        // if ($agent->save()) {
        //     $resp = 1;
        // }
        // return $resp;
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
            //guardar imagen
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
            // return ResponseHelper::success('Se guardó el número de turnos correctamente.', ['response' => $response]);
        }
        // $dataImg = $request->image;
        // $subido = "";
        // $urlGuardar = "";
        // $agent = Agent::where('user_id', $request->user_id)->first();
        // $client = Customers::where('user_id', $request->user_id)->first();

        // if ($request->hasFile('image')) {
        //     $nombre = $dataImg->getClientOriginalName();
        //     $extension = $dataImg->getClientOriginalExtension();
        //     $nuevoNombre = $nombre . "." . $extension;
        //     $subido = Storage::disk('perfil')->put($nombre, File::get($dataImg));
        //     if ($subido) {
        //         $urlGuardar = 'img/perfil/' . $nombre;
        //     }
        // }

        // if ($agent) {
        //     $agent->img = $urlGuardar;
        //     $agent->save();
        // }

        // if ($client) {
        //     $client->img = $urlGuardar;
        //     $client->save();
        // }

        // // Retornar una respuesta JSON para evitar el error en el frontend
        // return [
        //     'success' => $subido,
        //     'message' => $subido ? 'Imagen subida correctamente' : 'Error al subir la imagen',
        //     'path' => $urlGuardar
        // ];
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

        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // $user = Auth::user();
        // $user = User::find($user->id);
        // $user->password = Hash::make($request->password);

        // if ($user->save()) {
        //     $title = "Correcto";
        //     $mensaje = "La contraseña se actualizó correctamente";
        //     $status = "success";
        // }
        // return compact('title', 'mensaje', 'status');
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
        // $search = $request->code;

        // $agents = Agent::where('area_id', $request->area)
        //                 ->where(function ($query) use ($search) {
        //                     $query->whereRaw('CONCAT(name, " ", lastname) LIKE ?', ['%'.$search.'%'])
        //                         ->orWhere('code', 'like', '%'.$search.'%');
        //                 })->paginate(10);

        // return $agents;
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
        // $user_id = Auth::user()->id;
        // $agent = Agent::where('user_id', $user_id)->first();
        // return $agent;
    }

    public function saveTurn(TurnRequest $request)
    {
        // $user_id = Auth::user()->id;
        // $agent = Agent::where('user_id', $user_id)->first();

        // $cant_giro = $agent->number_turns;
        // $new_giro = 0;
        // if ($cant_giro > 0) {
        //     $new_giro = $cant_giro - 1;
        // }
        // $agent->number_turns = $new_giro;
        // $agent->save();
    }
}
