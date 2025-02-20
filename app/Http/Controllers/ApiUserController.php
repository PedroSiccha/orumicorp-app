<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ApiUser;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

class ApiUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ApiUser::all());
    }

    /**
     * @OA\Post(
     *     path="/api/v1/api-users",
     *     summary="Registrar un nuevo usuario",
     *     description="Permite registrar un usuario en la plataforma con un brand opcional.",
     *     tags={"API Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username", "email", "password", "password_confirmation"},
     *             @OA\Property(property="username", type="string", example="newuser"),
     *             @OA\Property(property="email", type="string", format="email", example="newuser@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
     *             @OA\Property(property="role", type="string", enum={"admin", "user"}, example="user"),
     *             @OA\Property(property="brand_id", type="integer", nullable=true, example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario registrado correctamente"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="username", type="string", example="newuser"),
     *                 @OA\Property(property="email", type="string", format="email", example="newuser@example.com"),
     *                 @OA\Property(property="status", type="string", example="active"),
     *                 @OA\Property(property="role", type="string", example="user"),
     *                 @OA\Property(property="brand", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="MYG Global"),
     *                     @OA\Property(property="site_url", type="string", example="https://myg-global.com")
     *                 ),
     *                 @OA\Property(property="token", type="string", example="abcdef123456"),
     *                 @OA\Property(property="token_expiry", type="string", format="date-time", example="2025-02-22T00:36:48.387243Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Error de validación"),
     *     @OA\Response(response=500, description="Error interno en el servidor"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function store(Request $request)
    {
        try {
            // 🔹 Validación de datos con mensajes personalizados
            $request->validate([
                'username' => 'required|unique:api_users|min:4|max:50',
                'email' => 'required|email|unique:api_users',
                'password' => 'required|min:8|confirmed',
                'role' => 'in:admin,user',
                'brand_id' => 'nullable|exists:brands,id'
            ], [
                'username.required' => 'El nombre de usuario es obligatorio.',
                'username.unique' => 'Este nombre de usuario ya está en uso.',
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El formato del correo no es válido.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'role.in' => 'El rol debe ser "admin" o "user".',
                'brand_id.exists' => 'El BRAND seleccionado no es válido.'
            ]);

            // 🔹 Generar token y expiración
            $token = Str::random(60);
            $expiry = Carbon::now()->addDays(7); // Token válido por 7 días

            // 🔹 Crear usuario
            $user = ApiUser::create([
                'username' => $request->username,
                'email' => $request->email,
                'password_hash' => Hash::make($request->password),
                'status' => 'active', // Usuario activo por defecto
                'role' => $request->role ?? 'user', // Por defecto "user"
                'brand_id' => $request->brand_id,
                'token' => $token,
                'token_expiry' => $expiry
            ]);

            // 🔹 Obtener el BRAND asociado (si existe)
            $brand = $user->brand ? [
                'id' => $user->brand->id,
                'name' => $user->brand->name,
                'site_url' => $user->brand->site_url
            ] : null;

            return response()->json([
                'message' => 'Usuario registrado correctamente',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'status' => $user->status,
                    'role' => $user->role,
                    'brand' => $brand,
                    'token' => $user->token,
                    'token_expiry' => $user->token_expiry
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al registrar usuario', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error interno en la base de datos, intenta de nuevo.'
            ], 500);
        } catch (Exception $e) {
            Log::error('Error inesperado en el registro', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado, intenta más tarde.'
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/api-users/brand",
     *     summary="Registrar un nuevo usuario con un BRAND",
     *     description="Permite registrar un usuario en la plataforma con la opción de crear un BRAND si no existe uno.",
     *     tags={"API Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username", "email", "password", "password_confirmation"},
     *             @OA\Property(property="username", type="string", example="newuser"),
     *             @OA\Property(property="email", type="string", format="email", example="newuser@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
     *             @OA\Property(property="role", type="string", enum={"admin", "user"}, example="user"),
     *             @OA\Property(property="brand_id", type="integer", nullable=true, example=1),
     *             @OA\Property(property="brand_name", type="string", nullable=true, example="MYG Global"),
     *             @OA\Property(property="brand_site_url", type="string", format="url", nullable=true, example="https://myg-global.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario y BRAND creados correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario registrado correctamente"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="username", type="string", example="newuser"),
     *                 @OA\Property(property="email", type="string", format="email", example="newuser@example.com"),
     *                 @OA\Property(property="status", type="string", example="active"),
     *                 @OA\Property(property="role", type="string", example="user"),
     *                 @OA\Property(property="brand", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="MYG Global"),
     *                     @OA\Property(property="site_url", type="string", example="https://myg-global.com")
     *                 ),
     *                 @OA\Property(property="token", type="string", example="abcdef123456"),
     *                 @OA\Property(property="token_expiry", type="string", format="date-time", example="2025-02-22T00:36:48.387243Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Error de validación"),
     *     @OA\Response(response=500, description="Error interno en el servidor"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function storeBrandAndUser(Request $request)
    {
        try {
            // 🔹 Validación de datos con mensajes personalizados
            $request->validate([
                'username' => 'required|unique:api_users|min:4|max:50',
                'email' => 'required|email|unique:api_users',
                'password' => 'required|min:8|confirmed',
                'role' => 'in:admin,user',
                'brand_id' => 'nullable|exists:brands,id',
                'brand_name' => 'nullable|string|max:255', // 🔹 Nombre del BRAND (si se quiere crear)
                'brand_site_url' => 'nullable|url|max:255' // 🔹 URL del BRAND (si se quiere crear)
            ], [
                'username.required' => 'El nombre de usuario es obligatorio.',
                'username.unique' => 'Este nombre de usuario ya está en uso.',
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El formato del correo no es válido.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'role.in' => 'El rol debe ser "admin" o "user".',
                'brand_id.exists' => 'El BRAND seleccionado no es válido.',
                'brand_name.string' => 'El nombre del BRAND debe ser un texto.',
                'brand_site_url.url' => 'El sitio del BRAND debe ser una URL válida.'
            ]);

            // 🔹 Crear BRAND si no se proporciona brand_id y se envían brand_name y brand_site_url
            if (!$request->brand_id && $request->brand_name && $request->brand_site_url) {
                $brand = Brand::create([
                    'name' => $request->brand_name,
                    'site_url' => $request->brand_site_url
                ]);
                $brandId = $brand->id; // 🔹 Asociamos el BRAND recién creado
            } else {
                $brandId = $request->brand_id; // 🔹 Se usa el brand_id existente
                $brand = $brandId ? Brand::find($brandId) : null;
            }

            // 🔹 Generar token y expiración
            $token = Str::random(60);
            $expiry = Carbon::now()->addDays(7);

            // 🔹 Crear usuario
            $user = ApiUser::create([
                'username' => $request->username,
                'email' => $request->email,
                'password_hash' => Hash::make($request->password),
                'status' => 'active',
                'role' => $request->role ?? 'user',
                'brand_id' => $brandId,
                'token' => $token,
                'token_expiry' => $expiry
            ]);

            // 🔹 Obtener los datos del BRAND (si existe)
            $brandData = $brand ? [
                'id' => $brand->id,
                'name' => $brand->name,
                'site_url' => $brand->site_url
            ] : null;

            return response()->json([
                'message' => 'Usuario registrado correctamente',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'status' => $user->status,
                    'role' => $user->role,
                    'brand' => $brandData,
                    'token' => $user->token,
                    'token_expiry' => $user->token_expiry
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al registrar usuario', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error interno en la base de datos, intenta de nuevo.'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado en el registro', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado, intenta más tarde.'
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Iniciar sesión",
     *     description="Permite a un usuario autenticarse en la plataforma y obtener un token de acceso.",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username", "password"},
     *             @OA\Property(property="username", type="string", example="admin_user"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Inicio de sesión exitoso."),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="username", type="string", example="admin_user"),
     *                 @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *                 @OA\Property(property="status", type="string", example="active"),
     *                 @OA\Property(property="role", type="string", example="admin"),
     *                 @OA\Property(property="brand", type="object",
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="name", type="string", example="MYG Global"),
     *                     @OA\Property(property="site_url", type="string", example="https://myg-global.com"),
     *                     @OA\Property(property="status", type="string", example="active")
     *                 ),
     *                 @OA\Property(property="token", type="string", example="abcdef123456"),
     *                 @OA\Property(property="token_expiry", type="string", format="date-time", example="2025-02-22T00:36:48.387243Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Credenciales incorrectas o usuario no encontrado"),
     *     @OA\Response(response=403, description="Usuario o BRAND inactivo"),
     *     @OA\Response(response=422, description="Error de validación"),
     *     @OA\Response(response=500, description="Error interno en el servidor"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function login(Request $request)
    {
        try {
            // 🔹 Validación con mensajes personalizados
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ], [
                'username.required' => 'El nombre de usuario es obligatorio.',
                'password.required' => 'La contraseña es obligatoria.'
            ]);

            // 🔹 Buscar usuario
            $user = ApiUser::where('username', $request->username)->first();

            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado.'], 401);
            }

            // 🔹 Verificar si el usuario está activo
            if ($user->status !== 'active') {
                return response()->json(['message' => 'Tu cuenta está inactiva o suspendida.'], 403);
            }

            // 🔹 Verificar si el usuario pertenece a un `BRAND`
            $brand = $user->brand ? [
                'id' => $user->brand->id,
                'name' => $user->brand->name,
                'site_url' => $user->brand->site_url,
                'status' => $user->brand->status
            ] : null;

            // 🔹 Si el usuario tiene un `BRAND`, verificar que también esté activo
            if ($brand && $brand['status'] !== 'active') {
                return response()->json(['message' => 'El BRAND asociado a tu cuenta está inactivo.'], 403);
            }

            // 🔹 Verificar contraseña
            if (!Hash::check($request->password, $user->password_hash)) {
                return response()->json(['message' => 'Credenciales incorrectas.'], 401);
            }

            // 🔹 Revocar cualquier sesión anterior
            $user->update([
                'token' => null,
                'token_expiry' => null
            ]);

            // 🔹 Generar nuevo token y tiempo de expiración
            $token = Str::random(60);
            $expiry = Carbon::now()->addDays(7); // Token válido por 7 días

            // 🔹 Guardar el nuevo token en la base de datos
            $user->update([
                'token' => $token,
                'token_expiry' => $expiry
            ]);

            return response()->json([
                'message' => 'Inicio de sesión exitoso.',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'status' => $user->status,
                    'role' => $user->role,
                    'brand' => $brand,
                    'token' => $token,
                    'token_expiry' => $expiry
                ]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos durante el login', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error interno en la base de datos, intenta de nuevo.'
            ], 500);
        } catch (Exception $e) {
            Log::error('Error inesperado en el login', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado, intenta más tarde.'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->attributes->get('user');

        if ($user) {
            $user->update([
                'token' => null,
                'token_expiry' => null
            ]);

            return response()->json(['message' => 'Logged out successfully']);
        }

        return response()->json(['message' => 'User not found'], 404);
    }


    /**
     * 🔹 Cambiar el estado de un API_USER (Solo `admin` puede hacer esto)
     *
     * @OA\Patch(
     *     path="/api/v1/api-users/{id}/status",
     *     summary="Cambiar el estado de un usuario API",
     *     tags={"API Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario API a modificar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", example="inactive")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estado del usuario actualizado correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Estado del usuario actualizado correctamente"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=5),
     *                 @OA\Property(property="username", type="string", example="usuario123"),
     *                 @OA\Property(property="status", type="string", example="inactive")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No tienes permisos para realizar esta acción."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario API no encontrado."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor."
     *     )
     * )
     */
    public function changeStatus(Request $request, $id)
    {
        try {
            // 🔹 Obtener el usuario autenticado
            $authenticatedUser = $request->attributes->get('user');

            // 🔹 Verificar si el usuario tiene permisos (`admin` requerido)
            if ($authenticatedUser->role !== 'admin') {
                return response()->json([
                    'message' => 'No tienes permisos para realizar esta acción.'
                ], 403);
            }

            // 🔹 Buscar el usuario a modificar
            $user = ApiUser::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'Usuario API no encontrado.'
                ], 404);
            }

            // 🔹 Validar la solicitud
            $request->validate([
                'status' => 'required|in:active,inactive,suspended'
            ], [
                'status.required' => 'El estado es obligatorio.',
                'status.in' => 'El estado debe ser "active", "inactive" o "suspended".'
            ]);

            // 🔹 Actualizar el estado del usuario
            $user->status = $request->status;
            $user->save();

            return response()->json([
                'message' => 'Estado del usuario actualizado correctamente',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'status' => $user->status
                ]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error en la base de datos al actualizar estado de usuario', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno en la base de datos.'], 500);
        } catch (\Exception $e) {
            Log::error('Error inesperado al actualizar estado de usuario', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
