<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CurrencyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/currencies",
     *     summary="Obtener lista de monedas",
     *     description="Devuelve una lista de todas las monedas disponibles en el sistema.",
     *     tags={"Currencies"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de monedas obtenida correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Lista de monedas obtenida exitosamente"),
     *             @OA\Property(
     *                 property="currencies",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="currency_code", type="string", example="USD"),
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
            $currencies = Currency::all();
            return response()->json(['message' => 'Lista de monedas obtenida exitosamente', 'currencies' => $currencies], 200);
        } catch (\Exception $e) {
            Log::error('Error inesperado al obtener monedas', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/currencies",
     *     summary="Crear una nueva moneda",
     *     description="Crea una nueva moneda con un código único.",
     *     tags={"Currencies"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"currency_code"},
     *             @OA\Property(property="currency_code", type="string", maxLength=3, example="USD"),
     *             @OA\Property(property="trading_account_group_id", type="integer", nullable=true, example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Moneda creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Moneda creada exitosamente"),
     *             @OA\Property(property="currency", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="currency_code", type="string", example="USD"),
     *                 @OA\Property(property="trading_account_group_id", type="integer", nullable=true, example=5),
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
     *                 @OA\Property(property="currency_code", type="array",
     *                     @OA\Items(type="string", example="El código de la moneda ya está en uso.")
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
                'currency_code' => 'required|string|max:3|unique:currencies,currency_code',
                'trading_account_group_id' => 'nullable|exists:trading_account_groups,id'
            ]);

            $currency = Currency::create($request->all());

            return response()->json(['message' => 'Moneda creada exitosamente', 'currency' => $currency], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al crear moneda', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al crear moneda', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/currencies/{id}",
     *     summary="Actualizar una moneda",
     *     description="Actualiza los datos de una moneda por su ID.",
     *     tags={"Currencies"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la moneda a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"currency_code"},
     *             @OA\Property(property="currency_code", type="string", maxLength=3, example="USD"),
     *             @OA\Property(property="trading_account_group_id", type="integer", nullable=true, example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Moneda actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Moneda actualizada exitosamente"),
     *             @OA\Property(property="currency", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="currency_code", type="string", example="USD"),
     *                 @OA\Property(property="trading_account_group_id", type="integer", nullable=true, example=5),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-20T14:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-21T14:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Moneda no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Moneda no encontrada.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="currency_code", type="array",
     *                     @OA\Items(type="string", example="El código de la moneda ya está en uso.")
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
                'currency_code' => 'required|string|max:3|unique:currencies,currency_code,' . $id,
                'trading_account_group_id' => 'nullable|exists:trading_account_groups,id'
            ]);

            $currency = Currency::findOrFail($id);
            $currency->update($request->all());

            return response()->json(['message' => 'Moneda actualizada exitosamente', 'currency' => $currency], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al actualizar moneda', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al actualizar moneda', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/currencies/{id}",
     *     summary="Eliminar una moneda",
     *     description="Elimina una moneda de la base de datos por su ID.",
     *     tags={"Currencies"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la moneda a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Moneda eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Moneda eliminada exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Moneda no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Moneda no encontrada.")
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
            $currency = Currency::findOrFail($id);
            $currency->delete();

            return response()->json(['message' => 'Moneda eliminada exitosamente'], 200);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al eliminar moneda', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al eliminar moneda', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }
}
