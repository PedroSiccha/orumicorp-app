<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Campaing;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CampaingController extends Controller
{

    public function saveCampaign(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $campaign = new Campaing();
            $campaign->name = $request->name;
            $campaign->description = $request->description;
            $campaign->start_date = $request->startDate;
            $campaign->end_date = $request->endDate;
            if ($campaign->save()) {
                $title = "Correcto";
                $mensaje = "Su campaña se registró correctamente";
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

        $campaigns = Campaing::get();

        return response()->json(["view"=>view('campaign.table.tableCampaign', compact('campaigns'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    public function updateCampaign(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $campaign = Campaing::find($request->id);
            $campaign->name = $request->name;
            $campaign->description = $request->description;
            $campaign->start_date = $request->startDate;
            $campaign->end_date = $request->endDate;

            if ($campaign->save()) {
                $title = "Correcto";
                $mensaje = "Se actualizó su campaña correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "Hubo un error al actualizar su campaña";
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

        $campaigns = Campaing::get();

        return response()->json(["view"=>view('campaign.table.tableCampaign', compact('campaigns'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function deleteCampaign(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $campaign = Campaing::find($request->id);
        if ($campaign == null) {
            $title = "Error";
            $mensaje = "Hubo un error con su campaña";
            $status = "error";
        }
        try {
            if ($campaign->delete()) {
                $title = "Correcto";
                $mensaje = "Su campaña se eliminó correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "No se pudo eliminar su campaña";
                $status = "error";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $campaigns = Campaing::get();

        return response()->json(["view"=>view('campaign.table.tableCampaign', compact('campaigns'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    /**
     * @OA\Get(
     *     path="/api/v1/campaigns",
     *     summary="Obtener todas las campañas asociadas al BRAND del usuario autenticado",
     *     description="Devuelve una lista de campañas filtradas por el BRAND del usuario autenticado con paginación.",
     *     tags={"Campaigns"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de campañas obtenida correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Campañas obtenidas correctamente"),
     *             @OA\Property(
     *                 property="campaigns",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Campaña de Promoción"),
     *                         @OA\Property(property="description", type="string", example="Campaña de promoción para nuevos clientes"),
     *                         @OA\Property(property="start_date", type="string", format="date", example="2025-02-01"),
     *                         @OA\Property(property="end_date", type="string", format="date", example="2025-03-01"),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-15T10:00:00Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-01T12:00:00Z"),
     *                         @OA\Property(
     *                             property="brand",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=2),
     *                             @OA\Property(property="name", type="string", example="MYG Global"),
     *                             @OA\Property(property="site_url", type="string", example="https://myg-global.com")
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(property="total", type="integer", example=50),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="last_page", type="integer", example=5),
     *                 @OA\Property(property="next_page_url", type="string", example="https://api.dominio.com/api/v1/campaigns?page=2"),
     *                 @OA\Property(property="prev_page_url", type="string", nullable=true, example=null)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="El usuario no tiene un BRAND asignado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El usuario no tiene un BRAND asignado.")
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
    public function indexApi(Request $request)
    {
        try {
            // 🔹 Obtener el API_USER autenticado
            $apiUser = $request->attributes->get('user');

            // 🔹 Verificar si el usuario tiene un `BRAND`
            if (!$apiUser->brand_id) {
                return response()->json([
                    'message' => 'El usuario no tiene un BRAND asignado.'
                ], 403);
            }

            // 🔹 Obtener campañas del mismo BRAND
            $campaigns = Campaing::where('brand_id', $apiUser->brand_id)
                                ->paginate(10);

            // 🔹 Formatear la respuesta para incluir datos del `BRAND`
            $formattedCampaigns = $campaigns->map(function ($campaign) {
                return [
                    'id' => $campaign->id,
                    'name' => $campaign->name,
                    'description' => $campaign->description,
                    'start_date' => $campaign->start_date,
                    'end_date' => $campaign->end_date,
                    'created_at' => $campaign->created_at,
                    'updated_at' => $campaign->updated_at,
                    'brand' => $campaign->brand ? [
                        'id' => $campaign->brand->id,
                        'name' => $campaign->brand->name,
                        'site_url' => $campaign->brand->site_url
                    ] : null
                ];
            });

            return response()->json([
                'message' => 'Campañas obtenidas correctamente',
                'campaigns' => [
                    'data' => $formattedCampaigns,
                    'pagination' => [
                        'current_page' => $campaigns->currentPage(),
                        'total_pages' => $campaigns->lastPage(),
                        'total_campaigns' => $campaigns->total(),
                        'per_page' => $campaigns->perPage(),
                        'next_page_url' => $campaigns->nextPageUrl(),
                        'prev_page_url' => $campaigns->previousPageUrl()
                    ]
                ]
            ], 200);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al obtener campañas', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (Exception $e) {
            Log::error('Error inesperado al obtener campañas', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/campaigns",
     *     summary="Crear una nueva campaña",
     *     description="Crea una nueva campaña asociada al BRAND del usuario autenticado.",
     *     tags={"Campaigns"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "start_date"},
     *             @OA\Property(property="name", type="string", example="Campaña de Promoción"),
     *             @OA\Property(property="description", type="string", example="Campaña de promoción para nuevos clientes"),
     *             @OA\Property(property="start_date", type="string", format="date", example="2025-02-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2025-03-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Campaña creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Campaña creada exitosamente"),
     *             @OA\Property(property="campaign", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Campaña de Promoción"),
     *                 @OA\Property(property="description", type="string", example="Campaña de promoción para nuevos clientes"),
     *                 @OA\Property(property="start_date", type="string", format="date", example="2025-02-01"),
     *                 @OA\Property(property="end_date", type="string", format="date", example="2025-03-01"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-15T10:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-01T12:00:00Z"),
     *                 @OA\Property(
     *                     property="brand",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="name", type="string", example="MYG Global"),
     *                     @OA\Property(property="site_url", type="string", example="https://myg-global.com")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="El usuario no tiene un BRAND asignado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El usuario no tiene un BRAND asignado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array",
     *                     @OA\Items(type="string", example="El campo nombre es obligatorio.")
     *                 ),
     *                 @OA\Property(property="start_date", type="array",
     *                     @OA\Items(type="string", example="El campo start_date es obligatorio.")
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
            // 🔹 Obtener el API_USER autenticado
            $apiUser = $request->attributes->get('user');

            // 🔹 Verificar si el usuario tiene un `BRAND`
            if (!$apiUser->brand_id) {
                return response()->json([
                    'message' => 'El usuario no tiene un BRAND asignado.'
                ], 403);
            }

            // 🔹 Validación de datos
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date'
            ]);

            // 🔹 Crear la campaña
            $campaign = Campaing::create([
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'brand_id' => $apiUser->brand_id
            ]);

            // 🔹 Obtener el `BRAND` asociado
            $brand = $campaign->brand ? [
                'id' => $campaign->brand->id,
                'name' => $campaign->brand->name,
                'site_url' => $campaign->brand->site_url
            ] : null;

            return response()->json([
                'message' => 'Campaña creada exitosamente',
                'campaign' => [
                    'id' => $campaign->id,
                    'name' => $campaign->name,
                    'description' => $campaign->description,
                    'start_date' => $campaign->start_date,
                    'end_date' => $campaign->end_date,
                    'created_at' => $campaign->created_at,
                    'updated_at' => $campaign->updated_at,
                    'brand' => $brand
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al crear campaña', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (Exception $e) {
            Log::error('Error inesperado al crear campaña', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/campaigns/{id}",
     *     summary="Actualizar una campaña",
     *     description="Actualiza los datos de una campaña solo si pertenece al BRAND del usuario autenticado.",
     *     tags={"Campaigns"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la campaña a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Campaña de Promoción Actualizada"),
     *             @OA\Property(property="description", type="string", example="Descripción actualizada de la campaña"),
     *             @OA\Property(property="start_date", type="string", format="date", example="2025-02-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2025-03-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaña actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Campaña actualizada exitosamente"),
     *             @OA\Property(property="campaign", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Campaña de Promoción Actualizada"),
     *                 @OA\Property(property="description", type="string", example="Descripción actualizada de la campaña"),
     *                 @OA\Property(property="start_date", type="string", format="date", example="2025-02-01"),
     *                 @OA\Property(property="end_date", type="string", format="date", example="2025-03-01"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-15T10:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-01T12:00:00Z"),
     *                 @OA\Property(
     *                     property="brand",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="name", type="string", example="MYG Global"),
     *                     @OA\Property(property="site_url", type="string", example="https://myg-global.com")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="El usuario no tiene un BRAND asignado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El usuario no tiene un BRAND asignado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaña no encontrada o no pertenece al BRAND del usuario",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Campaña no encontrada o no pertenece a tu BRAND.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="start_date", type="array",
     *                     @OA\Items(type="string", example="El campo start_date no tiene un formato válido.")
     *                 ),
     *                 @OA\Property(property="end_date", type="array",
     *                     @OA\Items(type="string", example="La fecha de finalización debe ser mayor o igual a la de inicio.")
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
            // 🔹 Obtener el API_USER autenticado
            $apiUser = $request->attributes->get('user');

            // 🔹 Verificar si el usuario tiene un `BRAND`
            if (!$apiUser->brand_id) {
                return response()->json([
                    'message' => 'El usuario no tiene un BRAND asignado.'
                ], 403);
            }

            // 🔹 Obtener la campaña
            $campaign = Campaing::where('brand_id', $apiUser->brand_id)->find($id);
            if (!$campaign) {
                return response()->json(['message' => 'Campaña no encontrada o no pertenece a tu BRAND.'], 404);
            }

            // 🔹 Validación de datos
            $request->validate([
                'name' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date'
            ]);

            // 🔹 Actualizar la campaña
            $campaign->update($request->only(['name', 'description', 'start_date', 'end_date']));

            // 🔹 Obtener el `BRAND` asociado
            $brand = $campaign->brand ? [
                'id' => $campaign->brand->id,
                'name' => $campaign->brand->name,
                'site_url' => $campaign->brand->site_url
            ] : null;

            return response()->json([
                'message' => 'Campaña creada exitosamente',
                'campaign' => [
                    'id' => $campaign->id,
                    'name' => $campaign->name,
                    'description' => $campaign->description,
                    'start_date' => $campaign->start_date,
                    'end_date' => $campaign->end_date,
                    'created_at' => $campaign->created_at,
                    'updated_at' => $campaign->updated_at,
                    'brand' => $brand
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al actualizar campaña', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al actualizar campaña', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/campaigns/{id}",
     *     summary="Eliminar una campaña",
     *     description="Elimina una campaña solo si pertenece al BRAND del usuario autenticado.",
     *     tags={"Campaigns"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la campaña a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaña eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Campaña eliminada exitosamente.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaña no encontrada o no pertenece al BRAND del usuario",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Campaña no encontrada o no pertenece a tu BRAND.")
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
    public function destroyApi(Request $request, $id)
    {
        try {
            // 🔹 Obtener el API_USER autenticado
            $apiUser = $request->attributes->get('user');

            // 🔹 Obtener la campaña
            $campaign = Campaing::where('brand_id', $apiUser->brand_id)->find($id);
            if (!$campaign) {
                return response()->json(['message' => 'Campaña no encontrada o no pertenece a tu BRAND.'], 404);
            }

            // 🔹 Eliminar la campaña
            $campaign->delete();

            return response()->json(['message' => 'Campaña eliminada exitosamente.'], 200);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al eliminar campaña', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al eliminar campaña', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }
}
