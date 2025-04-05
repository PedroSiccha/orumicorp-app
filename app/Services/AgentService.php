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
use Illuminate\Support\Facades\File;

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
<<<<<<< HEAD
        $user_id = Auth::user()->id;

        $agent = Agent::where('user_id', $user_id)->first();
        $client = Customers::where('user_id', $user_id)->first();
        $rouletteSpin = $agent->number_turns ?: 0;

        $dataUser = null;

        if ($agent) {
            $dataUser = $agent;
        }

        if ($client) {
            $dataUser = $client;
        }

        $agents = Agent::orderBy('created_at', 'desc')->paginate(10);
        $areas = Area::where('status', true)->get();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $roles = Role::get();

        return compact('agents', 'areas', 'premios1', 'premios2', 'roles', 'dataUser', 'rouletteSpin');
    }

    public function searchAgent($request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $name = "";

        try {
            $agent = Agent::where('code_voiso', $request->codeVoiso)->orWhere('code', $request->codeVoiso)->orderBy('created_at', 'desc')->first();
=======
        try {
                $agents = $this->agentRepository->paginate(10);
                $areas = $this->areaRepository->getAllActive();
                $roles = $this->rolesRepository->getAll();
                $dataUser = $this->agentRepository->getMyAgent();
                $rouletteSpin = $dataUser->number_turns;
>>>>>>> feature/fix-presentation


            return [
                'agents' => $agents,
                'areas' => $areas,
                'roles' => $roles,
                'rouletteSpin' => $rouletteSpin,
                'dataUser' => $dataUser
            ];
            // return ResponseHelper::success('Datos obtenidos correctamente.', [
            //     'agents' => $this->agentRepository->paginate(10), // Mantiene la paginación de Laravel
            //     'areas' => $this->areaRepository->getAllActive(), // Mantiene la colección de Eloquent
            //     'roles' => $this->rolesRepository->getAll() // Mantiene la colección de Eloquent
            // ]);
        } catch (Exception $e) {
            Log::error("Error en getAgentsData: " . $e->getMessage());
            return ResponseHelper::error('Error al obtener datos de agentes.');
        }
    }


<<<<<<< HEAD
        $role = Role::find($requestData->rol_id);
        if (!$role) {
            return [
                'title' => 'Error',
                'mensaje' => 'El rol proporcionado no existe.',
                'status' => 'error'
            ];
        }

        $validator = Validator::make($requestData->all(), [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            // 'code' => 'required|string|unique:agents,code|max:50',
            'codeVoiso' => 'required|string|unique:agents,code_voiso|max:50',
            'area_id' => 'required|integer|exists:areas,id',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'lastname.required' => 'El apellido es obligatorio.',
            'lastname.string' => 'El apellido debe ser una cadena de texto.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            // 'code.required' => 'El código es obligatorio.',
            // 'code.string' => 'El código debe ser una cadena de texto.',
            // 'code.unique' => 'El código ya está registrado.',
            'codeVoiso.required' => 'El código Voiso es obligatorio.',
            'codeVoiso.string' => 'El código Voiso debe ser una cadena de texto.',
            'codeVoiso.unique' => 'El código Voiso ya está registrado.',
            'area_id.required' => 'El área es obligatoria.',
            'area_id.integer' => 'El área proporcionada no existe.',
            'area_id.exists' => 'El área proporcionada no existe.',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            return [
                'title' => 'Error',
                'mensaje' => $errorMessages,
                'status' => 'error'
            ];
        }

        $pass = /*$requestData->code . */$requestData->codeVoiso;

        $user = new User();
        $user->name = $requestData->name;
        $user->email = $requestData->email;
        $user->password = Hash::make($pass);

        if ($user->save()) {
            $user->assignRole($role);
            $agent = new Agent();
            // $agent->code = $requestData->code;
            $agent->name = $requestData->name;
            $agent->lastname = $requestData->lastname;
            $agent->code_voiso = $requestData->codeVoiso;
            $agent->status = true;
            $agent->area_id = $requestData->area_id;
            $agent->user_id = $user->id;
            $agent->status_voiso = 'LIBRE';
            if ($agent->save()) {
                return [
                    'title' => 'Correcto',
                    'mensaje' => 'Se guardó el agente correctamente.',
                    'status' => 'success'
                ];
            } else {
                $user->delete();
                return [
                    'title' => 'Error',
                    'mensaje' => 'Error al guardar el agente.',
                    'status' => 'error'
                ];
            }
        } else {
            return [
                'title' => 'Error',
                'mensaje' => 'Error al guardar el usuario.',
                'status' => 'error'
            ];
        }

        return [
            'title' => 'Correcto',
            'mensaje' => 'Se guardó el agente correctamente.',
            'status' => 'success'
        ];
    }

    public function updateAgent($requestData) {
        $resp = 0;

        // Validar si el email ya existe en otro usuario
        $emailExists = User::where('email', $requestData->email)
                            ->where('id', '!=', function ($query) use ($requestData) {
                                $query->select('user_id')->from('agents')->where('id', $requestData->id);
                            })->exists();

        if ($emailExists) {
            return 0;
            // return [
            // 'title' => 'Error',
            // 'mensaje' => 'El correo electrónico ya está en uso por otro usuario.',
            // 'status' => 'error'
            // ];
        }

        // Validar si el codeVoiso ya existe en otro agente
        $codeVoisoExists = Agent::where('code_voiso', $requestData->codeVoiso)
                                ->where('id', '!=', $requestData->id)
                                ->exists();

        if ($codeVoisoExists) {
            return 0;
            // return [
            //     'title' => 'Error',
            //     'mensaje' => 'El código Voiso ya está en uso por otro agente.',
            //     'status' => 'error'
            // ];
        }

        $agent = Agent::find($requestData->id);
        $agent->name = $requestData->name;
        $agent->lastname = $requestData->lastname;
        $agent->area_id = $requestData->area_id;
        $agent->code_voiso = $requestData->codeVoiso;
        if ($agent->save()) {
            $user = User::find($agent->user_id);
            $user->name = $requestData->name;
            $user->email = $requestData->email;
            if ($user->save()) {
                if ($requestData->rol_id) {
                    $role = Role::find($requestData->rol_id);
                    $user->assignRole($role);
                }
                $resp = 1;
            }
        }

        return $resp;
    }

    public function cambiarEstadoAgente($agentId, $status) {
        $resp = 0;
        $agent = Agent::find($agentId);
        $agent->status = $status;
        if ($agent->save()) {
            $resp = 1;
        }
        return $resp;
    }

    public function eliminarAgente($agentId) {
        $resp = 0;
    
        try {
            DB::transaction(function () use ($agentId, &$resp) {
                $agent = Agent::find($agentId);
    
                if (!$agent) {
                    throw new \Exception("El agente no existe.");
                }
    
                $user = User::find($agent->user_id);
    
                if (!$user) {
                    throw new \Exception("El usuario asociado al agente no existe.");
                }
    
                DB::table('notification_update')->where('user_id', $user->id)->delete();
                
                if ($agent->delete()) {
                    if ($user->delete()) {
                        $resp = 1;
                    }
                }
            });
    
        } catch (\Exception $e) {
            Log::error("Error eliminando agente: " . $e->getMessage());
        }
    
        return $resp;
    }

    public function saveNumberTurns($agentId, $cantidad) {
        $resp = 0;
        $agent = Agent::find($agentId);
        $agent->number_turns = $cantidad;
        if ($agent->save()) {
            $resp = 1;
        }
        return $resp;
    }

    public function uploadImg($request) {
        $dataImg = $request->image;
        $subido = "";
        $urlGuardar = "";
        $agent = Agent::where('user_id', $request->user_id)->first();
        $client = Customers::where('user_id', $request->user_id)->first();

        if ($request->hasFile('image')) {
            $nombre = $dataImg->getClientOriginalName();
            $extension = $dataImg->getClientOriginalExtension();
            $nuevoNombre = $nombre . "." . $extension;
            $subido = Storage::disk('perfil')->put($nombre, File::get($dataImg));
            if ($subido) {
                $urlGuardar = 'img/perfil/' . $nombre;
            }
        }

        if ($agent) {
            $agent->img = $urlGuardar;
            $agent->save();
        }

        if ($client) {
            $client->img = $urlGuardar;
            $client->save();
        }

        // Retornar una respuesta JSON para evitar el error en el frontend
        return [
            'success' => $subido,
            'message' => $subido ? 'Imagen subida correctamente' : 'Error al subir la imagen',
            'path' => $urlGuardar
        ];
    }

    public function changePassword($request) {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        $user = Auth::user();
        $user = User::find($request->userId);
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            $title = "Correcto";
            $mensaje = "La contraseña se actualizó correctamente";
            $status = "success";
        }
        return compact('title', 'mensaje', 'status');
    }

    public function filterAgent($request)
=======
    public function searchAgent(string $code)
>>>>>>> feature/fix-presentation
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

<<<<<<< HEAD
        $agents = Agent::where('area_id', $request->area)
                        ->where(function ($query) use ($search) {
                            $query->whereRaw('CONCAT(name, " ", lastname) LIKE ?', ['%'.$search.'%'])
                                ->orWhere('code_voiso', 'like', '%'.$search.'%')
                                ->orWhere('code', 'like', '%'.$search.'%');

                        })->paginate(10);
=======
    public function saveAgent(array $data)
    {
        DB::beginTransaction();
        try {
            $role = $this->rolesRepository->findById($data['rol_id']);
            if (!$role) return ResponseHelper::error('El rol no existe.');
>>>>>>> feature/fix-presentation

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
