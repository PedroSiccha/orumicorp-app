<?php

use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CallStatusController;
use App\Http\Controllers\CampaingController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerCallController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\CustomerTokenController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\TradingAccountController;
use App\Http\Controllers\TradingAccountGroupController;
use App\Models\CampaignCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 🔹 Versión 1 de la API (v1)
Route::prefix('v1')->group(function () {

    // 🔐 Protegemos las rutas con autenticación Sanctum
    Route::post('api-users', [ApiUserController::class, 'store']); // 🔹 Crear Usuario
    Route::post('api-users/brand', [ApiUserController::class, 'storeBrandAndUser']); // 🔹 Crear Usuario y Proveedor
    Route::post('login', [ApiUserController::class, 'login']); // 🔹 Acceder
    Route::post('customers/login', [CustomersController::class, 'getCustomerToken']); // 🔹 Generar un token para el cliente
    Route::get('customers/deposit-redirect', [CustomersController::class, 'redirectToDeposit']); // 🔹 Generar URL de redirección a la página de depósito


    Route::middleware(['auth.api'])->group(function () {

        // 🔹 Usuarios API
        Route::get('api-users', [ApiUserController::class, 'index']); // 🔹 Listar usuarios API
        Route::patch('api-users/{id}/status', [ApiUserController::class, 'changeStatus']); // 🔹 Cambiar el estado del usuario
        Route::post('logout', [ApiUserController::class, 'logout']); // 🔹 Cerrar Sesion
         // Crear usuario API

        // 🔹 Clientes
        Route::get('customers', [CustomersController::class, 'index']); // 🔹 Listar clientes
        Route::post('customers', [CustomersController::class, 'store']); // 🔹 Crear cliente
        Route::get('customers/by-user', [CustomersController::class, 'getCustomersByBrand']); // 🔹 Obtener clientes por usuario
        Route::get('customers/customerStatuses', [CustomersController::class, 'getCustomersStatusByBrand']); // 🔹 Obtener estados del cliente
        Route::get('customers/{id}', [CustomersController::class, 'show']); // 🔹 Ver cliente
        Route::put('customers/{id}', [CustomersController::class, 'update']); // 🔹 Actualizar cliente
        Route::delete('customers/{id}', [CustomersController::class, 'destroy']); // 🔹 Eliminar cliente
        Route::get('customers/reports', [CustomersController::class, 'getFilteredCustomers']); // 🔹 Obtener clientes filtrados por diferentes rangos de fechas

        // 🔹 Campañas
        Route::get('campaigns', [CampaingController::class, 'indexApi']); // 🔹 Listar Campañas
        Route::post('campaigns', [CampaingController::class, 'storeApi']); // 🔹 Crear Campañas
        Route::put('campaigns/{id}', [CampaingController::class, 'updateApi']); // 🔹 Actualizar Campañas
        Route::delete('campaigns/{id}', [CampaingController::class, 'destroyApi']); // 🔹 Eliminar Campañas

        // 🔹 Marcas
        Route::get('brands', [BrandController::class, 'index']);
        Route::post('brands', [BrandController::class, 'store']);
        Route::get('brands/{id}', [BrandController::class, 'show']);
        Route::put('brands/{id}', [BrandController::class, 'update']);
        Route::delete('brands/{id}', [BrandController::class, 'destroy']);

        // 🔹 Plataformas
        Route::get('platforms', [PlatformController::class, 'indexApi']); // 🔹 Listar plataformas activas
        Route::get('platforms/all', [PlatformController::class, 'getAllPlatformsApi']); // 🔹 Listar todas las plataformas
        Route::post('platforms/', [PlatformController::class, 'storeApi']); // 🔹 Crear plataforma
        Route::put('platforms/{id}', [PlatformController::class, 'updateApi']); // 🔹 Actualizar plataforma
        Route::patch('platforms/{id}/status', [PlatformController::class, 'changeStatusApi']); // 🔹 Cambiar estado
        Route::delete('platforms/{id}', [PlatformController::class, 'destroyApi']); // 🔹 Eliminar plataforma

        // 🔹 Cuentas de Trading
        Route::get('trading-accounts', [TradingAccountController::class, 'index']); // 🔹 Listar cuentas de traiding
        Route::post('trading-accounts', [TradingAccountController::class, 'store']); // 🔹 Crear Cuenta de traiding
        Route::put('trading-accounts/{id}', [TradingAccountController::class, 'update']); // 🔹 Actualizar cuenta de traiding
        Route::delete('trading-accounts/{id}', [TradingAccountController::class, 'destroy']); // 🔹 Eliminar cuenta de traiding

        // 🔹 Grupos de Cuentas de Trading
        Route::get('trading-account-groups', [TradingAccountGroupController::class, 'index']); // 🔹 Listar grupos de cuentas de traiding
        Route::post('trading-account-groups', [TradingAccountGroupController::class, 'store']); // 🔹 Crear grupo de cuentas de traiding
        Route::put('trading-account-groups/{id}', [TradingAccountGroupController::class, 'update']); // 🔹 Actualizar grupos de cuentas de traiding
        Route::delete('trading-account-groups/{id}', [TradingAccountGroupController::class, 'destroy']); // 🔹 Eliminar grupo de cuentas de traiding
        Route::get('trading-account-groups/brands/{brand_id}/platforms/{platform_id}/groups', [TradingAccountGroupController::class, 'getGroupsByBrandAndPlatform']); // 🔹 Obtenga grupos de cuentas comerciales de marca

        // 🔹 Estados de Llamadas
        Route::get('call-statuses', [CallStatusController::class, 'index']);
        Route::post('call-statuses', [CallStatusController::class, 'store']);
        Route::get('call-statuses/{id}', [CallStatusController::class, 'show']);
        Route::put('call-statuses/{id}', [CallStatusController::class, 'update']);
        Route::delete('call-statuses/{id}', [CallStatusController::class, 'destroy']);

        // 🔹 Llamadas de Clientes
        Route::get('customer-calls', [CustomerCallController::class, 'index']);
        Route::post('customer-calls', [CustomerCallController::class, 'store']);
        Route::get('customer-calls/{id}', [CustomerCallController::class, 'show']);
        Route::put('customer-calls/{id}', [CustomerCallController::class, 'update']);
        Route::delete('customer-calls/{id}', [CustomerCallController::class, 'destroy']);

        // 🔹 Monedas
        Route::get('currencies', [CurrencyController::class, 'index']); // 🔹 Listas Monedas
        Route::post('currencies', [CurrencyController::class, 'store']); // 🔹 Crear Moneda
        Route::put('currencies/{id}', [CurrencyController::class, 'update']); // 🔹 Editar Moneda
        Route::delete('currencies/{id}', [CurrencyController::class, 'destroy']); // 🔹 Eliminar Moneda

        // 🔹 Depósitos
        Route::get('deposits', [DepositController::class, 'index']);
        Route::post('deposits', [DepositController::class, 'store']);
        Route::get('deposits/{id}', [DepositController::class, 'show']);
        Route::put('deposits/{id}', [DepositController::class, 'update']);
        Route::delete('deposits/{id}', [DepositController::class, 'destroy']);

    });
});