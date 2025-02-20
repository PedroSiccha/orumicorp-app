<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Http\Requests\StoreCustomersRequest;
use App\Http\Requests\UpdateCustomersRequest;
use App\Models\CustomerStatus;
use App\Models\CustomerToken;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CustomersController extends Controller
{
     /**
     * @OA\Get(
     *     path="/api/v1/customers",
     *     summary="Obtener la lista de clientes asociados al mismo BRAND del usuario autenticado",
     *     tags={"Customers"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes obtenida correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Clientes obtenidos correctamente"),
     *             @OA\Property(
     *                 property="customers",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="code", type="string", example="JD-1"),
     *                         @OA\Property(property="name", type="string", example="John"),
     *                         @OA\Property(property="lastname", type="string", example="Doe"),
     *                         @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *                         @OA\Property(property="phone", type="string", example="+123456789"),
     *                         @OA\Property(
     *                             property="brand",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=2),
     *                             @OA\Property(property="name", type="string", example="MYG Global")
     *                         ),
     *                         @OA\Property(property="is_lead", type="boolean", example=true),
     *                         @OA\Property(property="status", type="integer", example=1),
     *                         @OA\Property(
     *                             property="registered_by",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=3),
     *                             @OA\Property(property="username", type="string", example="admin_user")
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(property="total", type="integer", example=50),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="last_page", type="integer", example=5),
     *                 @OA\Property(property="next_page_url", type="string", example="https://api.dominio.com/api/v1/customers?page=2"),
     *                 @OA\Property(property="prev_page_url", type="string", nullable=true, example=null)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="El usuario no tiene un BRAND asignado.",
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
    public function index(Request $request)
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
    
            // 🔹 Obtener los clientes del mismo BRAND con paginación
            $customers = Customers::where('brand_id', $apiUser->brand_id)
                ->with(['brand', 'apiUser'])
                ->paginate(10); // Paginación de 10 resultados por página
    
            // 🔹 Formatear la respuesta para cada cliente
            $formattedCustomers = $customers->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'code' => $customer->code,
                    'name' => $customer->name,
                    'lastname' => $customer->lastname,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'brand' => $customer->brand ? [
                        'id' => $customer->brand->id,
                        'name' => $customer->brand->name
                    ] : null,
                    'is_lead' => $customer->is_lead,
                    'status' => $customer->status,
                    'registered_by' => [
                        'id' => $customer->apiUser->id,
                        'username' => $customer->apiUser->username
                    ]
                ];
            });
    
            return response()->json([
                'message' => 'Clientes obtenidos correctamente',
                'customers' => [
                    'data' => $formattedCustomers,
                    'pagination' => [
                        'current_page' => $customers->currentPage(),
                        'total_pages' => $customers->lastPage(),
                        'total_customers' => $customers->total(),
                        'per_page' => $customers->perPage(),
                        'next_page_url' => $customers->nextPageUrl(),
                        'prev_page_url' => $customers->previousPageUrl()
                    ]
                ]
            ], 200);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al obtener clientes', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al obtener clientes', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/customers/brand",
     *     summary="Obtener clientes asociados al BRAND del usuario autenticado",
     *     description="Obtiene la lista de clientes que pertenecen al mismo BRAND del usuario autenticado. Permite filtrar por el `api_user_id` opcionalmente.",
     *     tags={"Customers"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="api_user_id",
     *         in="query",
     *         required=false,
     *         description="Filtrar clientes por ID del usuario que los registró",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes obtenida correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Clientes obtenidos correctamente"),
     *             @OA\Property(
     *                 property="customers",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="code", type="string", example="JD-1"),
     *                         @OA\Property(property="name", type="string", example="John"),
     *                         @OA\Property(property="lastname", type="string", example="Doe"),
     *                         @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *                         @OA\Property(property="phone", type="string", example="+123456789"),
     *                         @OA\Property(
     *                             property="brand",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=2),
     *                             @OA\Property(property="name", type="string", example="MYG Global")
     *                         ),
     *                         @OA\Property(property="is_lead", type="boolean", example=true),
     *                         @OA\Property(property="status", type="integer", example=1),
     *                         @OA\Property(
     *                             property="registered_by",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=3),
     *                             @OA\Property(property="username", type="string", example="admin_user")
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(property="total", type="integer", example=50),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="last_page", type="integer", example=5),
     *                 @OA\Property(property="next_page_url", type="string", example="https://api.dominio.com/api/v1/customers/brand?page=2"),
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
    public function getCustomersByBrand(Request $request)
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

            // 🔹 Obtener el filtro opcional de `api_user_id`
            $apiUserId = $request->query('api_user_id');

            // 🔹 Construir la consulta base
            $query = Customers::where('brand_id', $apiUser->brand_id);

            // 🔹 Aplicar filtro por `api_user_id` si se proporciona
            if ($apiUserId) {
                $query->where('api_user_id', $apiUserId);
            }

            // 🔹 Obtener los clientes con paginación
            $customers = $query->with(['brand', 'apiUser'])->paginate(10);

            // 🔹 Formatear la respuesta
            $formattedCustomers = $customers->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'code' => $customer->code,
                    'name' => $customer->name,
                    'lastname' => $customer->lastname,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'brand' => $customer->brand ? [
                        'id' => $customer->brand->id,
                        'name' => $customer->brand->name
                    ] : null,
                    'is_lead' => $customer->is_lead,
                    'status' => $customer->status,
                    'registered_by' => [
                        'id' => $customer->apiUser->id,
                        'username' => $customer->apiUser->username
                    ]
                ];
            });

            return response()->json([
                'message' => 'Clientes obtenidos correctamente',
                'customers' => [
                    'data' => $formattedCustomers,
                    'pagination' => [
                        'current_page' => $customers->currentPage(),
                        'total_pages' => $customers->lastPage(),
                        'total_customers' => $customers->total(),
                        'per_page' => $customers->perPage(),
                        'next_page_url' => $customers->nextPageUrl(),
                        'prev_page_url' => $customers->previousPageUrl()
                    ]
                ]
            ], 200);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al obtener clientes', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al obtener clientes', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/v1/customers",
     *     summary="Registrar un nuevo cliente",
     *     description="Registra un nuevo cliente asociado al mismo BRAND del usuario autenticado. Soporta Cold Leads y Live Traffic.",
     *     tags={"Clientes"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"isLead", "name", "lastname", "email"},
     *             @OA\Property(property="isLead", type="boolean", example=true),
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="lastname", type="string", example="Doe"),
     *             @OA\Property(property="phone", type="string", example="+123456789"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="countryId", type="string", example="US"),
     *             @OA\Property(property="campaignId", type="integer", example=1035),
     *             @OA\Property(property="productName", type="string", example="Trading Package"),
     *             @OA\Property(property="marketingInfo", type="string", example="Referral from social media"),
     *             @OA\Property(property="password", type="string", minLength=5, example="strongPassword123"),
     *             @OA\Property(property="tradingAccountsForex", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="currencyId", type="integer", example=1),
     *                     @OA\Property(property="isDemo", type="boolean", example=false),
     *                     @OA\Property(property="platformId", type="integer", example=4),
     *                     @OA\Property(property="tradingAccountGroupId", type="integer", example=6)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente registrado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente registrado exitosamente"),
     *             @OA\Property(property="customer", type="object",
     *                 @OA\Property(property="id", type="integer", example=2),
     *                 @OA\Property(property="code", type="string", example="JD-2"),
     *                 @OA\Property(property="name", type="string", example="John"),
     *                 @OA\Property(property="lastname", type="string", example="Doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *                 @OA\Property(property="phone", type="string", example="+123456789"),
     *                 @OA\Property(property="date_admission", type="string", format="date-time", example="2025-02-16T10:00:00Z"),
     *                 @OA\Property(property="brand", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="MYG Global"),
     *                     @OA\Property(property="site_url", type="string", example="https://myg-global.com")
     *                 ),
     *                 @OA\Property(property="is_lead", type="boolean", example=true),
     *                 @OA\Property(property="status", type="integer", example=1),
     *                 @OA\Property(property="country", type="string", example="US"),
     *                 @OA\Property(property="registered_by", type="object",
     *                     @OA\Property(property="id", type="integer", example=3),
     *                     @OA\Property(property="username", type="string", example="admin_user")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="El correo electrónico ya está registrado.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno en la base de datos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error interno en la base de datos, intenta de nuevo.")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            // 🔹 Obtener el API_USER autenticado
            $apiUser = $request->attributes->get('user');
            $brandId = $apiUser->brand_id; // Se obtiene del usuario autenticado

            // 🔹 Verificar si el usuario ya ha realizado una solicitud en los últimos 1 segundo
            $cacheKey = "api_user_{$apiUser->id}_last_request";
            if (Cache::has($cacheKey)) {
                return response()->json([
                    'message' => 'Debes esperar al menos 1 segundo entre solicitudes.'
                ], 429);
            }
            Cache::put($cacheKey, now(), 1); // Guardamos la última solicitud por 1 segundo

            // 🔹 Obtener el `id_status` del estado "NEW"
            $newStatus = CustomerStatus::where('name', 'NEW')->first();
            if (!$newStatus) {
                return response()->json(['message' => 'No se encontró el estado "NEW" en la tabla customers_status.'], 500);
            }

            // 🔹 Validación de datos basada en si es Cold Lead o Live Traffic
            $rules = [
                'isLead' => 'required|boolean',
                'name' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'phone' => 'nullable|string|max:255',
                'email' => 'required|email|unique:customers',
                'countryId' => 'nullable|string|max:10',
                'campaignId' => 'nullable|integer',
            ];

            // Si es "Live Traffic", validaciones adicionales
            if (!$request->isLead) {
                $rules = array_merge($rules, [
                    'productName' => 'required|string|max:255',
                    'marketingInfo' => 'nullable|string|max:255',
                    'password' => 'required|string|min:5',
                    'tradingAccountsForex' => 'nullable|array',
                    'tradingAccountsForex.*.currencyId' => 'required_with:tradingAccountsForex|integer',
                    'tradingAccountsForex.*.isDemo' => 'required_with:tradingAccountsForex|boolean',
                    'tradingAccountsForex.*.platformId' => 'required_with:tradingAccountsForex|integer',
                    'tradingAccountsForex.*.tradingAccountGroupId' => 'required_with:tradingAccountsForex|integer',
                ]);
            }

            // 🔹 Validar la solicitud
            $request->validate($rules, [
                'email.unique' => 'El correo electrónico ya está registrado.',
                'password.min' => 'La contraseña debe tener al menos 5 caracteres.'
            ]);

            // 🔹 Crear el cliente y asociarlo al API_USER autenticado
            $customer = Customers::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'email' => $request->email,
                'brand_id' => $brandId,
                'is_lead' => $request->isLead,
                'status' => true, // Siempre activo por defecto
                'city' => $request->city ?? null,
                'country' => $request->countryId ?? null,
                'comment' => $request->comment ?? null,
                'api_user_id' => $apiUser->id,
                'date_admission' => Carbon::now(),
                'id_provider' => $brandId, // 🔹 Se establece igual al `brand_id`
                'id_status' => $newStatus->id // 🔹 Estado "NEW"
            ]);

            // 🔹 Generar `code` basado en el nombre, apellido e ID del cliente
            $customer->code = strtoupper(Str::substr($customer->name, 0, 1) . Str::substr($customer->lastname, 0, 1)) . '-' . $customer->id;
            $customer->save();

            // 🔹 Registrar cuentas de trading si existen
            if (!$request->isLead && $request->has('tradingAccountsForex')) {
                foreach ($request->tradingAccountsForex as $tradingAccount) {
                    $customer->tradingAccounts()->create([
                        'currency_id' => $tradingAccount['currencyId'],
                        'is_demo' => $tradingAccount['isDemo'],
                        'platform_id' => $tradingAccount['platformId'],
                        'trading_account_group_id' => $tradingAccount['tradingAccountGroupId']
                    ]);
                }
            }

            // 🔹 Obtener la información del BRAND si está asociado
            $brand = $customer->brand ? [
                'id' => $customer->brand->id,
                'name' => $customer->brand->name,
                'site_url' => $customer->brand->site_url
            ] : null;

            return response()->json([
                'message' => 'Cliente registrado exitosamente',
                'customer' => [
                    'id' => $customer->id,
                    'code' => $customer->code,
                    'name' => $customer->name,
                    'lastname' => $customer->lastname,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'date_admission' => $customer->date_admission,
                    'brand' => $brand,
                    'is_lead' => $customer->is_lead,
                    'status' => $customer->status,
                    'country' => $customer->country,
                    'registered_by' => [
                        'id' => $apiUser->id,
                        'username' => $apiUser->username
                    ]
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al registrar cliente', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error interno en la base de datos, intenta de nuevo.'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado en el registro de cliente', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado, intenta más tarde.'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/customers/{id}",
     *     summary="Obtener detalles de un cliente por ID",
     *     description="Devuelve los detalles de un cliente específico según su ID.",
     *     tags={"Customers"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente a consultar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del cliente obtenidos correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="code", type="string", example="JD-1"),
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="lastname", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="phone", type="string", example="+123456789"),
     *             @OA\Property(property="brand_id", type="integer", example=2),
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-20T14:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-22T18:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente no encontrado.")
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
    public function show($id)
    {
        try {
            $customer = Customers::findOrFail($id);
            return response()->json($customer, 200);
        } catch (QueryException $e) {
            Log::error('Error al obtener cliente', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Cliente no encontrado.'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/customers/{id}",
     *     summary="Actualizar datos de un cliente",
     *     description="Actualiza los datos de un cliente existente por su ID.",
     *     tags={"Customers"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="lastname", type="string", example="Doe"),
     *             @OA\Property(property="phone", type="string", example="+123456789"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="date_admission", type="string", format="date", example="2025-02-20"),
     *             @OA\Property(property="brand_id", type="integer", example=2),
     *             @OA\Property(property="is_lead", type="boolean", example=true),
     *             @OA\Property(property="status", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente actualizado correctamente"),
     *             @OA\Property(property="customer", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John"),
     *                 @OA\Property(property="lastname", type="string", example="Doe"),
     *                 @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *                 @OA\Property(property="phone", type="string", example="+123456789"),
     *                 @OA\Property(property="brand_id", type="integer", example=2),
     *                 @OA\Property(property="is_lead", type="boolean", example=true),
     *                 @OA\Property(property="status", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente no encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="El correo electrónico ya está en uso.")
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
            $customer = Customers::findOrFail($id);

            // Validación de datos
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'lastname' => 'sometimes|string|max:255',
                'phone' => 'nullable|string|max:255',
                'email' => 'sometimes|email|unique:customers,email,' . $id,
                'date_admission' => 'nullable|date',
                'brand_id' => 'sometimes|exists:brands,id',
                'is_lead' => 'boolean',
                'status' => 'boolean',
            ]);

            $customer->update($request->all());

            return response()->json([
                'message' => 'Cliente actualizado correctamente',
                'customer' => $customer
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al actualizar cliente', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Cliente no encontrado.'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/customers/{id}",
     *     summary="Eliminar un cliente",
     *     description="Elimina un cliente de la base de datos según su ID.",
     *     tags={"Customers"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente eliminado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente no encontrado.")
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
            $customer = Customers::findOrFail($id);
            $customer->delete();

            return response()->json(['message' => 'Cliente eliminado correctamente'], 200);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al eliminar cliente', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Cliente no encontrado.'], 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/customers/status",
     *     summary="Obtener clientes con su estado asociado",
     *     description="Obtiene la lista de clientes asociados al mismo BRAND del usuario autenticado junto con su estado.",
     *     tags={"Customers"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes obtenida correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Clientes obtenidos correctamente"),
     *             @OA\Property(
     *                 property="customers",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="code", type="string", example="JD-1"),
     *                         @OA\Property(property="name", type="string", example="John"),
     *                         @OA\Property(property="lastname", type="string", example="Doe"),
     *                         @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *                         @OA\Property(property="phone", type="string", example="+123456789"),
     *                         @OA\Property(
     *                             property="brand",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=2),
     *                             @OA\Property(property="name", type="string", example="MYG Global")
     *                         ),
     *                         @OA\Property(
     *                             property="status",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=5),
     *                             @OA\Property(property="name", type="string", example="Active"),
     *                             @OA\Property(property="color", type="string", example="#28a745")
     *                         ),
     *                         @OA\Property(
     *                             property="registered_by",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=3),
     *                             @OA\Property(property="username", type="string", example="admin_user")
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(property="total", type="integer", example=50),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="last_page", type="integer", example=5),
     *                 @OA\Property(property="next_page_url", type="string", example="https://api.dominio.com/api/v1/customers/status?page=2"),
     *                 @OA\Property(property="prev_page_url", type="string", nullable=true, example=null)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="El usuario no tiene un BRAND asignado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No tienes un BRAND asignado.")
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
    public function getCustomersStatusByBrand(Request $request)
    {
        try {
            // 🔹 Obtener el usuario autenticado
            $apiUser = $request->attributes->get('user');

            // 🔹 Verificar si el usuario tiene un `BRAND`
            if (!$apiUser->brand_id) {
                return response()->json([
                    'message' => 'No tienes un BRAND asignado.'
                ], 403);
            }

            // 🔹 Obtener clientes del mismo `BRAND` con el estado asociado
            $customers = Customers::where('brand_id', $apiUser->brand_id)
                ->with(['statusCustomer', 'brand', 'apiUser'])
                ->paginate(10);

            // 🔹 Formatear la respuesta
            $formattedCustomers = $customers->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'code' => $customer->code,
                    'name' => $customer->name,
                    'lastname' => $customer->lastname,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'brand' => $customer->brand ? [
                        'id' => $customer->brand->id,
                        'name' => $customer->brand->name
                    ] : null,
                    'status' => $customer->statusCustomer ? [
                        'id' => $customer->statusCustomer->id,
                        'name' => $customer->statusCustomer->name,
                        'color' => $customer->statusCustomer->color
                    ] : null,
                    'registered_by' => $customer->apiUser ? [
                        'id' => $customer->apiUser->id,
                        'username' => $customer->apiUser->username
                    ] : null
                ];
            });

            return response()->json([
                'message' => 'Clientes obtenidos correctamente',
                'customers' => [
                    'data' => $formattedCustomers,
                    'pagination' => [
                        'current_page' => $customers->currentPage(),
                        'total_pages' => $customers->lastPage(),
                        'total_customers' => $customers->total(),
                        'per_page' => $customers->perPage(),
                        'next_page_url' => $customers->nextPageUrl(),
                        'prev_page_url' => $customers->previousPageUrl()
                    ]
                ]
            ], 200);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al obtener clientes', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al obtener clientes', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/customers/token",
     *     summary="Obtener token de autenticación para un cliente",
     *     description="Genera un token de autenticación para un cliente basado en su email y el BRAND asociado.",
     *     tags={"Customer Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "brand_id"},
     *             @OA\Property(property="email", type="string", format="email", example="customer@example.com"),
     *             @OA\Property(property="brand_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token generado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token generado correctamente"),
     *             @OA\Property(property="token", type="string", example="Bearer abcdef123456")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Cliente no encontrado o no autorizado"),
     *     @OA\Response(response=422, description="Error de validación"),
     *     @OA\Response(response=500, description="Error interno en la base de datos"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function getCustomerToken(Request $request)
    {
        try {
            // 🔹 Validación de datos
            $request->validate([
                'email' => 'required|email|exists:customers,email',
                'brand_id' => 'required|exists:brands,id'
            ], [
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El formato del correo no es válido.',
                'email.exists' => 'El cliente no existe en la base de datos.',
                'brand_id.required' => 'El ID del BRAND es obligatorio.',
                'brand_id.exists' => 'El BRAND no existe en la base de datos.'
            ]);

            // 🔹 Buscar al cliente en la base de datos
            $customer = Customers::where('email', $request->email)
                ->where('brand_id', $request->brand_id)
                ->first();

            // 🔹 Si no se encuentra el cliente
            if (!$customer) {
                return response()->json(['message' => 'Cliente no encontrado o no autorizado.'], 401);
            }

            // 🔹 Generar nuevo token y tiempo de expiración
            $token = 'Bearer ' . Str::random(60);
            $expiry = Carbon::now()->addMinutes(15); // Token expira en 15 minutos

            // 🔹 Guardar el nuevo token en la base de datos
            $customer->customerToken()->updateOrCreate(
                ['customer_id' => $customer->id],
                ['token' => $token, 'token_expiry' => $expiry]
            );

            return response()->json([
                'message' => 'Token generado correctamente',
                'token' => $token
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al generar el token del cliente', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error interno en la base de datos.'
            ], 500);
        } catch (Exception $e) {
            Log::error('Error inesperado en la autenticación del cliente', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado.'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/customers/deposit-redirect",
     *     summary="Redirigir cliente a la página de depósito",
     *     description="Genera una URL segura para que el cliente sea redirigido a la página de depósito utilizando su token de autenticación.",
     *     tags={"Customer Authentication"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Token del cliente en formato Bearer Token",
     *         @OA\Schema(type="string", example="Bearer abcdef123456")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Redirección generada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Redirección generada exitosamente"),
     *             @OA\Property(property="redirect_url", type="string", example="https://myg-global.com/?prfToken=Bearer abcdef123456&prfRedirectUrl=/deposit")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Token inválido o expirado"),
     *     @OA\Response(response=404, description="No se encontró un BRAND válido asociado al cliente"),
     *     @OA\Response(response=500, description="Error interno en la base de datos"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function redirectToDeposit(Request $request)
    {
        try {
            // 🔹 Obtener el token del cliente desde los headers
            $authorizationHeader = $request->header('Authorization');

            if (!$authorizationHeader || !str_starts_with($authorizationHeader, 'Bearer ')) {
                return response()->json(['message' => 'Token inválido o no proporcionado.'], 401);
            }

            $token = str_replace('Bearer ', '', $authorizationHeader);

            // 🔹 Buscar el token válido y obtener el cliente asociado
            $customerToken = CustomerToken::where('token', 'Bearer ' . $token)
                ->where('token_expiry', '>', now())
                ->with('customer.brand') // Cargar la relación del customer con el brand
                ->first();

            if (!$customerToken) {
                return response()->json(['message' => 'Token inválido o expirado.'], 401);
            }

            // 🔹 Obtener el BRAND y su `site_url`
            $customer = $customerToken->customer;
            if (!$customer || !$customer->brand || !$customer->brand->site_url) {
                return response()->json(['message' => 'No se encontró un BRAND válido asociado al cliente.'], 404);
            }

            $brandSiteUrl = rtrim($customer->brand->site_url, '/'); // Asegurar que no haya doble "/" en la URL

            // 🔹 Construir URL de redirección segura
            $redirectUrl = "{$brandSiteUrl}/?prfToken=Bearer {$token}&prfRedirectUrl=/deposit";

            return response()->json([
                'message' => 'Redirección generada exitosamente',
                'redirect_url' => $redirectUrl
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al generar la redirección del cliente', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error interno en la base de datos.'
            ], 500);
        } catch (Exception $e) {
            Log::error('Error inesperado en la redirección del cliente', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado.'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/customers/filter",
     *     summary="Obtener lista de clientes con filtros",
     *     description="Filtra la lista de clientes según rango de fechas de registro, FTD, última comunicación, último depósito o último inicio de sesión.",
     *     tags={"Customers"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="registrationDate_gte",
     *         in="query",
     *         required=false,
     *         description="Filtrar clientes con fecha de registro mayor o igual a esta fecha",
     *         @OA\Schema(type="string", format="date", example="2024-05-01")
     *     ),
     *     @OA\Parameter(
     *         name="registrationDate_lte",
     *         in="query",
     *         required=false,
     *         description="Filtrar clientes con fecha de registro menor o igual a esta fecha",
     *         @OA\Schema(type="string", format="date", example="2024-05-31")
     *     ),
     *     @OA\Parameter(
     *         name="ftdDate_gte",
     *         in="query",
     *         required=false,
     *         description="Filtrar clientes con fecha FTD mayor o igual a esta fecha",
     *         @OA\Schema(type="string", format="date", example="2024-06-01")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes obtenida correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Lista de clientes obtenida exitosamente"),
     *             @OA\Property(
     *                 property="customers",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=528),
     *                     @OA\Property(property="name", type="string", example="John"),
     *                     @OA\Property(property="lastname", type="string", example="Doe"),
     *                     @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *                     @OA\Property(property="registration_date", type="string", format="date-time"),
     *                     @OA\Property(property="last_deposit_date", type="string", format="date-time"),
     *                     @OA\Property(property="last_login", type="string", format="date-time")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No autorizado.")
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
    public function getFilteredCustomers(Request $request)
    {
        try {
            // 🔹 Obtener el usuario autenticado
            $apiUser = $request->attributes->get('user');

            if (!$apiUser || !$apiUser->brand_id) {
                return response()->json(['message' => 'No autorizado.'], 401);
            }

            // 🔹 Construir consulta
            $query = Customers::where('brand_id', $apiUser->brand_id);

            // 🔹 Aplicar filtros de fechas si están presentes
            $filters = [
                'date_admission' => ['registrationDate_gte', 'registrationDate_lte'],
                'ftd_date' => ['ftdDate_gte', 'ftdDate_lte'],
                'last_communication_date' => ['lastCommunicationDate_gte', 'lastCommunicationDate_lte'],
                'last_deposit_date' => ['lastDepositDate_gte', 'lastDepositDate_lte'],
                'last_login' => ['lastLoginDate_gte', 'lastLoginDate_lte'],
            ];

            foreach ($filters as $column => $params) {
                if ($request->has($params[0])) {
                    $query->where($column, '>=', Carbon::parse($request->query($params[0])));
                }
                if ($request->has($params[1])) {
                    $query->where($column, '<=', Carbon::parse($request->query($params[1])));
                }
            }

            // 🔹 Obtener los clientes filtrados
            $customers = $query->get([
                'id', 'name', 'lastname', 'email', 'date_admission as registration_date',
                'last_deposit_date', 'last_login'
            ]);

            return response()->json([
                'message' => 'Lista de clientes obtenida exitosamente',
                'customers' => $customers
            ], 200);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al obtener reportes de clientes', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (Exception $e) {
            Log::error('Error inesperado al obtener reportes de clientes', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

}
