<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Info(title="API Documentation", version="1.0.0")
 */
class PlatformController extends Controller
{

    public function savePlatform(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $platform = new Platform();
            $platform->name = $request->name;
            $platform->description = $request->description;
            $platform->status = 'active';
            if ($platform->save()) {
                $title = "Correcto";
                $mensaje = "Su platform se registró correctamente";
                $status = "success";
            }

        } catch (ValidationException $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $platforms = Platform::get();

        return response()->json(["view"=>view('platform.table.tablePlatform', compact('platforms'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function updatePlatform(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $platform = Platform::find($request->id);
            $platform->name = $request->name;
            $platform->description = $request->description;

            if ($platform->save()) {
                $title = "Correcto";
                $mensaje = "Se actualizó su platform correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "Hubo un error al actualizar su platform";
                $status = "error";
            }

        } catch (ValidationException $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Verificar los datos del registro";
            $status = "error";
        }

        $platforms = Platform::get();

        return response()->json(["view"=>view('platform.table.tablePlatform', compact('platforms'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function deletePlatform(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $platform = Platform::find($request->id);
        if ($platform == null) {
            $title = "Error";
            $mensaje = "Hubo un error con su platform";
            $status = "error";
        }
        try {
            if ($platform->delete()) {
                $title = "Correcto";
                $mensaje = "Su platform se eliminó correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "No se pudo eliminar su platform";
                $status = "error";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $platforms = Platform::get();

        return response()->json(["view"=>view('platform.table.tablePlatform', compact('platforms'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    /**
     * @OA\Get(
     *     path="/api/v1/platforms/active",
     *     summary="Obtener todas las plataformas activas",
     *     description="Devuelve una lista de todas las plataformas cuyo estado es 'active'.",
     *     tags={"Platforms"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de plataformas activas obtenida correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Plataformas activas obtenidas correctamente"),
     *             @OA\Property(
     *                 property="platforms",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="MetaTrader 4"),
     *                     @OA\Property(property="description", type="string", example="Plataforma de trading"),
     *                     @OA\Property(property="status", type="string", example="active"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-15T10:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-01T12:00:00Z")
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
    public function indexApi()
    {
        try {
            $platforms = Platform::where('status', 'active')->get();

            return response()->json([
                'message' => 'Plataformas activas obtenidas correctamente',
                'platforms' => $platforms
            ], 200);
        } catch (Exception $e) {
            Log::error('Error al obtener plataformas activas', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/platforms",
     *     summary="Obtener todas las plataformas (activas e inactivas)",
     *     description="Devuelve una lista de todas las plataformas, incluyendo tanto las activas como las inactivas.",
     *     tags={"Platforms"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de plataformas obtenida correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Todas las plataformas obtenidas correctamente"),
     *             @OA\Property(
     *                 property="platforms",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="MetaTrader 4"),
     *                     @OA\Property(property="description", type="string", example="Plataforma de trading"),
     *                     @OA\Property(property="status", type="string", example="active"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-15T10:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-01T12:00:00Z")
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
    public function getAllPlatformsApi()
    {
        try {
            $platforms = Platform::all();

            return response()->json([
                'message' => 'Todas las plataformas obtenidas correctamente',
                'platforms' => $platforms
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al obtener todas las plataformas', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/platforms",
     *     summary="Crear una nueva plataforma",
     *     description="Crea una nueva plataforma con estado 'active' por defecto.",
     *     tags={"Platforms"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="MetaTrader 4"),
     *             @OA\Property(property="description", type="string", example="Plataforma de trading profesional"),
     *             @OA\Property(property="marketing_info", type="string", example="Plataforma popular para forex trading")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Plataforma creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Plataforma creada exitosamente"),
     *             @OA\Property(property="platform", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="MetaTrader 4"),
     *                 @OA\Property(property="description", type="string", example="Plataforma de trading profesional"),
     *                 @OA\Property(property="marketing_info", type="string", example="Plataforma popular para forex trading"),
     *                 @OA\Property(property="status", type="string", example="active"),
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
     *                     @OA\Items(type="string", example="El campo nombre ya está en uso.")
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
    public function storeApi(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:platforms',
                'description' => 'nullable|string',
                'marketing_info' => 'nullable|string'
            ]);

            $platform = Platform::create([
                'name' => $request->name,
                'description' => $request->description,
                'marketing_info' => $request->marketing_info,
                'status' => 'active' // Se crea activa por defecto
            ]);

            return response()->json([
                'message' => 'Plataforma creada exitosamente',
                'platform' => $platform
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al crear plataforma', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al crear plataforma', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/platforms/{id}/status",
     *     summary="Cambiar el estado de una plataforma",
     *     description="Cambia el estado de una plataforma entre 'active' e 'inactive'.",
     *     tags={"Platforms"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la plataforma cuyo estado se va a cambiar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estado de la plataforma actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Estado de la plataforma actualizado correctamente"),
     *             @OA\Property(property="platform", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="MetaTrader 4"),
     *                 @OA\Property(property="description", type="string", example="Plataforma de trading"),
     *                 @OA\Property(property="status", type="string", example="inactive"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-20T14:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-21T14:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plataforma no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Plataforma no encontrada.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno en la base de datos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ha ocurrido un error inesperado.")
     *         )
     *     )
     * )
     */
    public function changeStatusApi($id)
    {
        try {
            $platform = Platform::findOrFail($id);
            $platform->status = ($platform->status === 'active') ? 'inactive' : 'active';
            $platform->save();

            return response()->json([
                'message' => 'Estado de la plataforma actualizado correctamente',
                'platform' => $platform
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al cambiar estado de la plataforma', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/platforms/{id}",
     *     summary="Actualizar una plataforma",
     *     description="Actualiza los datos de una plataforma existente según su ID.",
     *     tags={"Platforms"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la plataforma a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="MetaTrader 4"),
     *             @OA\Property(property="description", type="string", example="Plataforma de trading actualizada"),
     *             @OA\Property(property="marketing_info", type="string", example="Información actualizada sobre la plataforma"),
     *             @OA\Property(property="status", type="string", enum={"active", "inactive"}, example="active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Plataforma actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Plataforma actualizada exitosamente"),
     *             @OA\Property(property="platform", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="MetaTrader 4"),
     *                 @OA\Property(property="description", type="string", example="Plataforma de trading actualizada"),
     *                 @OA\Property(property="marketing_info", type="string", example="Información actualizada sobre la plataforma"),
     *                 @OA\Property(property="status", type="string", example="active"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-20T14:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-21T14:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plataforma no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Plataforma no encontrada.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array",
     *                     @OA\Items(type="string", example="El nombre ya está en uso.")
     *                 ),
     *                 @OA\Property(property="status", type="array",
     *                     @OA\Items(type="string", example="El estado debe ser 'active' o 'inactive'.")
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
    public function updateApi(Request $request, $id)
    {
        try {
            $platform = Platform::findOrFail($id);

            $request->validate([
                'name' => 'nullable|string|max:255|unique:platforms,name,' . $id,
                'description' => 'nullable|string',
                'marketing_info' => 'nullable|string',
                'status' => 'nullable|in:active,inactive'
            ]);

            $platform->update($request->only(['name', 'description', 'marketing_info', 'status']));

            return response()->json([
                'message' => 'Plataforma actualizada exitosamente',
                'platform' => $platform
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al actualizar plataforma', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al actualizar plataforma', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/platforms/{id}",
     *     summary="Eliminar una plataforma",
     *     description="Elimina una plataforma de la base de datos por su ID.",
     *     tags={"Platforms"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la plataforma a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Plataforma eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Plataforma eliminada exitosamente.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plataforma no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Plataforma no encontrada.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno en la base de datos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ha ocurrido un error inesperado.")
     *         )
     *     )
     * )
     */
    public function destroyApi($id)
    {
        try {
            $platform = Platform::findOrFail($id);
            $platform->delete();

            return response()->json(['message' => 'Plataforma eliminada exitosamente.'], 200);
        } catch (\Exception $e) {
            Log::error('Error al eliminar plataforma', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }
}
