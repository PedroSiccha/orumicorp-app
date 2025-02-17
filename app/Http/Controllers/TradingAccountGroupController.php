<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TradingAccount;
use App\Models\TradingAccountGroup;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TradingAccountGroupController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/trading-account-groups",
     *     summary="Obtener lista de grupos de cuentas de trading",
     *     description="Devuelve una lista de todos los grupos de cuentas de trading disponibles.",
     *     tags={"Trading Account Groups"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de grupos de cuentas de trading obtenida correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Lista de grupos obtenida exitosamente"),
     *             @OA\Property(
     *                 property="groups",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=3),
     *                     @OA\Property(property="name", type="string", example="Forex Standard Group"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-20T14:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-21T14:00:00Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno en la base de datos o error inesperado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ha ocurrido un error inesperado.")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $groups = TradingAccountGroup::all();
            return response()->json(['message' => 'Lista de grupos obtenida exitosamente', 'groups' => $groups], 200);
        } catch (\Exception $e) {
            Log::error('Error inesperado al obtener grupos de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/trading-account-groups",
     *     summary="Crear un nuevo grupo de cuentas de trading",
     *     description="Crea un nuevo grupo de cuentas de trading con un nombre único.",
     *     tags={"Trading Account Groups"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Forex Standard Group"),
     *             @OA\Property(property="description", type="string", example="Grupo estándar de trading en forex")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Grupo de cuentas de trading creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Grupo de cuentas de trading creado exitosamente"),
     *             @OA\Property(property="group", type="object",
     *                 @OA\Property(property="id", type="integer", example=5),
     *                 @OA\Property(property="name", type="string", example="Forex Standard Group"),
     *                 @OA\Property(property="description", type="string", example="Grupo estándar de trading en forex"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-20T14:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-20T14:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array",
     *                     @OA\Items(type="string", example="El nombre del grupo ya está en uso.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno en la base de datos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error interno en la base de datos.")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:trading_account_groups,name',
                'description' => 'nullable|string'
            ]);

            $group = TradingAccountGroup::create($request->all());

            return response()->json(['message' => 'Grupo de cuentas de trading creado exitosamente', 'group' => $group], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al crear grupo de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al crear grupo de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/trading-account-groups/{id}",
     *     summary="Actualizar un grupo de cuentas de trading",
     *     description="Actualiza los datos de un grupo de cuentas de trading por su ID.",
     *     tags={"Trading Account Groups"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del grupo de cuentas de trading a actualizar",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Forex Standard Group"),
     *             @OA\Property(property="description", type="string", example="Grupo de trading actualizado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Grupo de cuentas de trading actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Grupo actualizado exitosamente"),
     *             @OA\Property(property="group", type="object",
     *                 @OA\Property(property="id", type="integer", example=5),
     *                 @OA\Property(property="name", type="string", example="Forex Standard Group"),
     *                 @OA\Property(property="description", type="string", example="Grupo de trading actualizado"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-20T14:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-21T14:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Grupo de cuentas de trading no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Grupo de cuentas de trading no encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array",
     *                     @OA\Items(type="string", example="El nombre del grupo ya está en uso.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno en la base de datos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error interno en la base de datos.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:trading_account_groups,name,' . $id,
                'description' => 'nullable|string'
            ]);

            $group = TradingAccountGroup::findOrFail($id);
            $group->update($request->all());

            return response()->json(['message' => 'Grupo actualizado exitosamente', 'group' => $group], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al actualizar grupo de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al actualizar grupo de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/trading-account-groups/{id}",
     *     summary="Eliminar un grupo de cuentas de trading",
     *     description="Elimina un grupo de cuentas de trading de la base de datos por su ID.",
     *     tags={"Trading Account Groups"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del grupo de cuentas de trading a eliminar",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Grupo de cuentas de trading eliminado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Grupo eliminado exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Grupo de cuentas de trading no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Grupo de cuentas de trading no encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno en la base de datos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error interno en la base de datos.")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $group = TradingAccountGroup::findOrFail($id);
            $group->delete();

            return response()->json(['message' => 'Grupo eliminado exitosamente'], 200);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al eliminar grupo de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al eliminar grupo de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/trading-account-groups/{brand_id}/platforms/{platform_id}",
     *     summary="Obtener grupos de cuentas de trading por BRAND y PLATFORM",
     *     description="Obtiene los grupos de cuentas de trading filtrados por BRAND y PLATFORM asociados al usuario autenticado.",
     *     tags={"Trading Account Groups"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="brand_id",
     *         in="path",
     *         required=true,
     *         description="ID del BRAND para filtrar los grupos de cuentas de trading",
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Parameter(
     *         name="platform_id",
     *         in="path",
     *         required=true,
     *         description="ID de la plataforma para filtrar los grupos de cuentas de trading",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="_expand[]",
     *         in="query",
     *         required=false,
     *         description="Expandir información adicional como currency (Ejemplo: _expand[]=currency)",
     *         @OA\Schema(type="array", @OA\Items(type="string", example="currency"))
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de grupos obtenida correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Lista de grupos obtenida exitosamente"),
     *             @OA\Property(
     *                 property="groups",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=10),
     *                     @OA\Property(property="name", type="string", example="Forex Standard Group"),
     *                     @OA\Property(property="platform_id", type="integer", example=1),
     *                     @OA\Property(property="brand_id", type="integer", example=2),
     *                     @OA\Property(property="currency", type="object", nullable=true,
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="currency_code", type="string", example="USD")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No tienes permiso para acceder a estos datos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No tienes permiso para acceder a estos datos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno en la base de datos o error inesperado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ha ocurrido un error inesperado.")
     *         )
     *     )
     * )
     */
    public function getGroupsByBrandAndPlatform(Request $request, $brand_id, $platform_id)
    {
        try {
            // 🔹 Obtener el usuario autenticado
            $apiUser = $request->attributes->get('user');

            // 🔹 Verificar si el usuario tiene acceso al BRAND a través del customer
            if ($apiUser->brand_id != $brand_id) {
                return response()->json([
                    'message' => 'No tienes permiso para acceder a estos datos'
                ], 403);
            }

            // 🔹 Consultar los grupos de cuentas de trading filtrados por `brand_id` a través del `customer` y `platform_id`
            $query = TradingAccount::whereHas('customer', function ($query) use ($brand_id) {
                    $query->where('brand_id', $brand_id);
                })
                ->where('platform_id', $platform_id);

            // 🔹 Si `_expand[]=currency` está en la consulta, expandir la moneda
            if ($request->query('_expand') && in_array('currency', $request->query('_expand'))) {
                $query->with('currency:id,currency_code');
            }

            // 🔹 Incluir información del grupo de trading
            $query->with('tradingAccountGroup:id,name');

            $groups = $query->get();

            // 🔹 Formatear la respuesta según la estructura esperada
            $formattedGroups = $groups->map(function ($group) use ($request) {
                return [
                    'id' => $group->id,
                    'name' => $group->tradingAccountGroup ? $group->tradingAccountGroup->name : 'Sin Grupo',
                    'platform_id' => $group->platform_id,
                    'brand_id' => $group->customer->brand_id, // Ahora se obtiene desde el customer
                    'currency' => $request->query('_expand') && in_array('currency', $request->query('_expand'))
                        ? [
                            'id' => $group->currency->id,
                            'currency_code' => $group->currency->currency_code
                        ]
                        : null
                ];
            });

            return response()->json([
                'message' => 'Lista de grupos obtenida exitosamente',
                'groups' => $formattedGroups
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al obtener grupos de cuentas de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }


}
