<?php

namespace App\Http\Controllers;

use App\Models\RoleTableConfiguration;
use App\Models\UserTableConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class TableConfigController extends Controller
{
    public function getTableConfig($tableName)
    {
        $user = Auth::user();
        
        // Primero buscar configuración específica del usuario
        $userConfig = UserTableConfiguration::where('user_id', $user->id)
                                        ->where('table_name', $tableName)
                                        ->first();
        
        if ($userConfig) {
            return response()->json(['config' => $userConfig->visible_columns]);
        }
        
        // Si no hay configuración del usuario, buscar por rol
        $role = $user->roles->first();
        if ($role) {
            $roleConfig = RoleTableConfiguration::where('role_id', $role->id)
                                                ->where('table_name', $tableName)
                                                ->first();
            if ($roleConfig) {
                return response()->json(['config' => $roleConfig->visible_columns]);
            }
        }
        
        return response()->json(['config' => []]);
    }

    public function saveTableConfig(Request $request)
    {
        $request->validate([
            'table_name' => 'required|string',
            'visible_columns' => 'required|array',
            'scope' => 'required|string',
            'role_id' => 'nullable|integer'
        ]);
        // dd($request->role_id);
        
        $user = Auth::user();
        
        if ($request->scope === 'user') {
            UserTableConfiguration::updateOrCreate(
                ['user_id' => $user->id, 'table_name' => $request->table_name],
                ['visible_columns' => json_encode($request->visible_columns)]
            );
            return response()->json(['message' => 'Configuración guardada para el usuario']);
        }
        
        if ($request->scope === 'role') {
            $role = Role::find($request->role_id);
            if (!$role) {
                return response()->json(['error' => 'Rol no encontrado'], 404);
            } 
            RoleTableConfiguration::updateOrCreate(
                ['role_id' => $role->id, 'table_name' => $request->table_name],
                ['visible_columns' => json_encode($request->visible_columns)]
            );
            return response()->json(['message' => 'Configuración guardada para el rol']);
        }
        
        return response()->json(['error' => 'Opción no válida'], 400);
    }

    public function resetTableConfig(Request $request)
    {
        $request->validate(['table_name' => 'required|string']);
        
        $user = Auth::user();
        UserTableConfiguration::where('user_id', $user->id)
                            ->where('table_name', $request->table_name)
                            ->delete();
        
        return response()->json(['message' => 'Configuración restablecida a valores por defecto']);
    }

}
