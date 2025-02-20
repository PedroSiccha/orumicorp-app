<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customers;
use App\Models\Platform;
use App\Models\TradingAccount;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TradingAccountController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/trading-accounts",
     *     summary="Obtener la lista de cuentas de trading",
     *     description="Obtiene la lista de cuentas de trading asociadas a clientes que pertenecen al mismo BRAND del usuario autenticado.",
     *     tags={"Trading Accounts"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de cuentas de trading obtenida correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Lista de cuentas de trading obtenida exitosamente"),
     *             @OA\Property(
     *                 property="trading_accounts",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=10),
     *                     @OA\Property(
     *                         property="customer",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=528),
     *                         @OA\Property(property="name", type="string", example="John Doe")
     *                     ),
     *                     @OA\Property(
     *                         property="currency",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="currency_code", type="string", example="USD")
     *                     ),
     *                     @OA\Property(property="is_demo", type="boolean", example=true),
     *                     @OA\Property(
     *                         property="platform",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="name", type="string", example="MetaTrader 4")
     *                     ),
     *                     @OA\Property(
     *                         property="trading_account_group",
     *                         type="object",
     *                         nullable=true,
     *                         @OA\Property(property="id", type="integer", example=3),
     *                         @OA\Property(property="name", type="string", example="Forex Standard Group")
     *                     )
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
    public function index(Request $request)
    {
        try {
            $apiUser = $request->attributes->get('user');

            $tradingAccounts = TradingAccount::whereHas('customer', function ($query) use ($apiUser) {
                $query->where('brand_id', $apiUser->brand_id);
            })->with(['customer:id,name', 'currency:id,currency_code', 'platform:id,name', 'tradingAccountGroup:id,name'])
            ->paginate(10);

            $formattedAccounts = $tradingAccounts->map(function ($tradingAccount) {
                return [
                    'id' => $tradingAccount->id,
                    'customer' => [
                        'id' => $tradingAccount->customer->id,
                        'name' => $tradingAccount->customer->name
                    ],
                    'currency' => [
                        'id' => $tradingAccount->currency->id,
                        'currency_code' => $tradingAccount->currency->currency_code
                    ],
                    'is_demo' => $tradingAccount->is_demo,
                    'platform' => [
                        'id' => $tradingAccount->platform->id,
                        'name' => $tradingAccount->platform->name
                    ],
                    'trading_account_group' => $tradingAccount->tradingAccountGroup ? [
                        'id' => $tradingAccount->tradingAccountGroup->id,
                        'name' => $tradingAccount->tradingAccountGroup->name
                    ] : null
                ];
            });

            return response()->json([
                'message' => 'Lista de cuentas de trading obtenida exitosamente',
                'trading_accounts' => $formattedAccounts
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error inesperado al obtener cuentas de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/v1/trading-accounts",
     *     summary="Crear una nueva cuenta de trading",
     *     description="Crea una nueva cuenta de trading para un cliente, verificando que la plataforma y la moneda estén activas.",
     *     tags={"Trading Accounts"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"customer_id", "currency_id", "is_demo", "platform_id"},
     *             @OA\Property(property="customer_id", type="integer", example=528),
     *             @OA\Property(property="currency_id", type="integer", example=1),
     *             @OA\Property(property="is_demo", type="boolean", example=true),
     *             @OA\Property(property="platform_id", type="integer", example=2),
     *             @OA\Property(property="trading_account_group_id", type="integer", nullable=true, example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cuenta de trading creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cuenta de trading creada exitosamente"),
     *             @OA\Property(property="trading_account", type="object",
     *                 @OA\Property(property="id", type="integer", example=10),
     *                 @OA\Property(property="customer", type="object",
     *                     @OA\Property(property="id", type="integer", example=528),
     *                     @OA\Property(property="name", type="string", example="John Doe")
     *                 ),
     *                 @OA\Property(property="currency", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="currency_code", type="string", example="USD")
     *                 ),
     *                 @OA\Property(property="is_demo", type="boolean", example=true),
     *                 @OA\Property(property="platform", type="object",
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="name", type="string", example="MetaTrader 4")
     *                 ),
     *                 @OA\Property(property="trading_account_group", type="object", nullable=true,
     *                     @OA\Property(property="id", type="integer", example=3),
     *                     @OA\Property(property="name", type="string", example="Forex Standard Group")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="La plataforma seleccionada no está activa",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="La plataforma seleccionada no está activa.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No tienes permisos para crear cuentas de trading para este cliente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No tienes permisos para crear cuentas de trading para este cliente.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="customer_id", type="array",
     *                     @OA\Items(type="string", example="El ID del cliente es obligatorio.")
     *                 ),
     *                 @OA\Property(property="currency_id", type="array",
     *                     @OA\Items(type="string", example="La moneda no existe en la base de datos.")
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
            // 🔹 Obtener el usuario autenticado
            $apiUser = $request->attributes->get('user');

            // 🔹 Validaciones de entrada
            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'currency_id' => 'required|exists:currencies,id',
                'is_demo' => 'required|boolean',
                'platform_id' => 'required|exists:platforms,id',
                'trading_account_group_id' => 'nullable|exists:trading_account_groups,id'
            ], [
                'customer_id.required' => 'El ID del cliente es obligatorio.',
                'customer_id.exists' => 'El cliente no existe en la base de datos.',
                'currency_id.required' => 'El ID de la moneda es obligatorio.',
                'currency_id.exists' => 'La moneda no existe en la base de datos.',
                'is_demo.required' => 'Debes especificar si la cuenta es demo o real.',
                'is_demo.boolean' => 'El valor de demo debe ser verdadero o falso.',
                'platform_id.required' => 'El ID de la plataforma es obligatorio.',
                'platform_id.exists' => 'La plataforma no existe en la base de datos.',
                'trading_account_group_id.exists' => 'El grupo de cuentas de trading no existe.'
            ]);

            // 🔹 Verificar que el cliente pertenece al mismo `BRAND` del usuario autenticado
            $customer = Customers::findOrFail($request->customer_id);
            if ($customer->brand_id !== $apiUser->brand_id) {
                return response()->json([
                    'message' => 'No tienes permisos para crear cuentas de trading para este cliente.'
                ], 403);
            }

            // 🔹 Verificar si la plataforma y la moneda están activas
            $platform = Platform::findOrFail($request->platform_id);
            if ($platform->status !== 'active') {
                return response()->json([
                    'message' => 'La plataforma seleccionada no está activa.'
                ], 400);
            }

            $currency = Currency::findOrFail($request->currency_id);

            // 🔹 Crear cuenta de trading
            $tradingAccount = TradingAccount::create([
                'customer_id' => $request->customer_id,
                'currency_id' => $request->currency_id,
                'is_demo' => $request->is_demo,
                'platform_id' => $request->platform_id,
                'trading_account_group_id' => $request->trading_account_group_id ?? null // Permite NULL si no se envía
            ]);

            // 🔹 Formatear respuesta con datos completos
            return response()->json([
                'message' => 'Cuenta de trading creada exitosamente',
                'trading_account' => [
                    'id' => $tradingAccount->id,
                    'customer' => [
                        'id' => $customer->id,
                        'name' => $customer->name
                    ],
                    'currency' => [
                        'id' => $currency->id,
                        'currency_code' => $currency->currency_code
                    ],
                    'is_demo' => $tradingAccount->is_demo,
                    'platform' => [
                        'id' => $platform->id,
                        'name' => $platform->name
                    ],
                    'trading_account_group' => $tradingAccount->tradingAccountGroup ? [
                        'id' => $tradingAccount->tradingAccountGroup->id,
                        'name' => $tradingAccount->tradingAccountGroup->name
                    ] : null
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al crear cuenta de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (Exception $e) {
            Log::error('Error inesperado al crear cuenta de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }


    /**
     * @OA\Put(
     *     path="/api/v1/trading-accounts/{id}",
     *     summary="Actualizar una cuenta de trading",
     *     description="Actualiza los datos de una cuenta de trading solo si pertenece a un cliente del mismo BRAND del usuario autenticado.",
     *     tags={"Trading Accounts"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la cuenta de trading a actualizar",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="currency_id", type="integer", example=1, nullable=true),
     *             @OA\Property(property="platform_id", type="integer", example=2, nullable=true),
     *             @OA\Property(property="is_demo", type="boolean", example=true),
     *             @OA\Property(property="trading_account_group_id", type="integer", nullable=true, example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cuenta de trading actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cuenta de trading actualizada exitosamente"),
     *             @OA\Property(property="trading_account", type="object",
     *                 @OA\Property(property="id", type="integer", example=10),
     *                 @OA\Property(property="customer", type="object",
     *                     @OA\Property(property="id", type="integer", example=528),
     *                     @OA\Property(property="name", type="string", example="John Doe")
     *                 ),
     *                 @OA\Property(property="currency", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="currency_code", type="string", example="USD")
     *                 ),
     *                 @OA\Property(property="is_demo", type="boolean", example=true),
     *                 @OA\Property(property="platform", type="object",
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="name", type="string", example="MetaTrader 4")
     *                 ),
     *                 @OA\Property(property="trading_account_group", type="object", nullable=true,
     *                     @OA\Property(property="id", type="integer", example=3),
     *                     @OA\Property(property="name", type="string", example="Forex Standard Group")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cuenta de trading no encontrada o no pertenece al BRAND del usuario",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cuenta de trading no encontrada o no pertenece a tu BRAND.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="currency_id", type="array",
     *                     @OA\Items(type="string", example="La moneda seleccionada no es válida.")
     *                 ),
     *                 @OA\Property(property="platform_id", type="array",
     *                     @OA\Items(type="string", example="La plataforma seleccionada no es válida.")
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
            $apiUser = $request->attributes->get('user');

            $request->validate([
                'currency_id' => 'exists:currencies,id',
                'platform_id' => 'exists:platforms,id',
                'is_demo' => 'boolean',
                'trading_account_group_id' => 'nullable|exists:trading_account_groups,id'
            ]);

            $tradingAccount = TradingAccount::whereHas('customer', function ($query) use ($apiUser) {
                $query->where('brand_id', $apiUser->brand_id);
            })->findOrFail($id);

            $tradingAccount->update($request->only(['currency_id', 'platform_id', 'is_demo', 'trading_account_group_id']));

            return response()->json([
                'message' => 'Cuenta de trading actualizada exitosamente',
                'trading_account' => [
                    'id' => $tradingAccount->id,
                    'customer' => [
                        'id' => $tradingAccount->customer->id,
                        'name' => $tradingAccount->customer->name
                    ],
                    'currency' => [
                        'id' => $tradingAccount->currency->id,
                        'currency_code' => $tradingAccount->currency->currency_code
                    ],
                    'is_demo' => $tradingAccount->is_demo,
                    'platform' => [
                        'id' => $tradingAccount->platform->id,
                        'name' => $tradingAccount->platform->name
                    ],
                    'trading_account_group' => $tradingAccount->tradingAccountGroup ? [
                        'id' => $tradingAccount->tradingAccountGroup->id,
                        'name' => $tradingAccount->tradingAccountGroup->name
                    ] : null
                ]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al actualizar cuenta de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al actualizar cuenta de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/v1/trading-accounts/{id}",
     *     summary="Eliminar una cuenta de trading",
     *     description="Elimina una cuenta de trading solo si pertenece a un cliente del mismo BRAND del usuario autenticado.",
     *     tags={"Trading Accounts"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la cuenta de trading a eliminar",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cuenta de trading eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cuenta de trading eliminada exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cuenta de trading no encontrada o no pertenece al BRAND del usuario",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cuenta de trading no encontrada o no pertenece a tu BRAND.")
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
    public function destroy(Request $request, $id)
    {
        try {
            $apiUser = $request->attributes->get('user');

            $tradingAccount = TradingAccount::whereHas('customer', function ($query) use ($apiUser) {
                $query->where('brand_id', $apiUser->brand_id);
            })->findOrFail($id);

            $tradingAccount->delete();

            return response()->json(['message' => 'Cuenta de trading eliminada exitosamente'], 200);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al eliminar cuenta de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al eliminar cuenta de trading', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    
}
