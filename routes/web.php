<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('/');

Auth::routes();

Route::middleware('checkip')->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('agents', [\App\Http\Controllers\AgentController::class, 'index'])->name('agents');
    Route::post('/saveAgent', [App\Http\Controllers\AgentController::class, 'saveAgent'])->name('saveAgent');
    Route::post('/searchAgent', [App\Http\Controllers\AgentController::class, 'searchAgent'])->name('searchAgent');
    Route::post('/updateAgent', [App\Http\Controllers\AgentController::class, 'updateAgent'])->name('updateAgent');
    Route::post('/cambiarEstadoAgente', [App\Http\Controllers\AgentController::class, 'cambiarEstadoAgente'])->name('cambiarEstadoAgente');
    Route::post('/eliminarAgente', [App\Http\Controllers\AgentController::class, 'eliminarAgente'])->name('eliminarAgente');
    Route::post('/saveNumberTurns', [App\Http\Controllers\AgentController::class, 'saveNumberTurns'])->name('saveNumberTurns');

    Route::get('areas', [\App\Http\Controllers\AreaController::class, 'index'])->name('areas');
    Route::post('/saveArea', [App\Http\Controllers\AreaController::class, 'saveArea'])->name('saveArea');
    Route::post('/updateArea', [App\Http\Controllers\AreaController::class, 'updateArea'])->name('updateArea');
    Route::post('/changeStatusArea', [App\Http\Controllers\AreaController::class, 'changeStatusArea'])->name('changeStatusArea');
    Route::post('/deleteArea', [App\Http\Controllers\AreaController::class, 'deleteArea'])->name('deleteArea');

    Route::get('/clients', [App\Http\Controllers\ClientsController::class, 'index'])->name('clients');
    Route::post('/saveCustomer', [App\Http\Controllers\ClientsController::class, 'saveCustomer'])->name('saveCustomer');
    Route::post('/asignAgent', [App\Http\Controllers\ClientsController::class, 'asignAgent'])->name('asignAgent');
    Route::post('/changeStatusClient', [App\Http\Controllers\ClientsController::class, 'changeStatusClient'])->name('changeStatusClient');
    Route::post('/updateClient', [App\Http\Controllers\ClientsController::class, 'updateClient'])->name('updateClient');
    Route::post('/deleteClient', [App\Http\Controllers\ClientsController::class, 'deleteClient'])->name('deleteClient');

    Route::get('/sales', [App\Http\Controllers\SalesController::class, 'index'])->name('sales');
    Route::post('/searchCustomer', [App\Http\Controllers\SalesController::class, 'searchCustomer'])->name('searchCustomer');
    Route::post('/saveSale', [App\Http\Controllers\SalesController::class, 'saveSale'])->name('saveSale');

    Route::get('/agentbonus', [App\Http\Controllers\AgentBonusController::class, 'index'])->name('agentBonus');
    Route::post('/saveBonus', [App\Http\Controllers\AgentBonusController::class, 'saveBonus'])->name('saveBonus');
    Route::post('/saveRetiro', [App\Http\Controllers\AgentBonusController::class, 'saveRetiro'])->name('saveRetiro');

    Route::get('/statisticstoday', [App\Http\Controllers\StatisticsTodayController::class, 'index'])->name('statisticsToday');
    Route::post('/filterStatistics', [App\Http\Controllers\StatisticsTodayController::class, 'filterStatistics'])->name('filterStatistics');

    Route::get('/parttime', [App\Http\Controllers\PartTimeController::class, 'index'])->name('partTime');
    Route::post('/registerAssistance', [App\Http\Controllers\PartTimeController::class, 'registerAssistance'])->name('registerAssistance');
    Route::post('/filterAssistance', [App\Http\Controllers\PartTimeController::class, 'filterAssistance'])->name('filterAssistance');

    Route::post('/saveTarget', [App\Http\Controllers\TargetController::class, 'saveTarget'])->name('saveTarget');

    Route::get('/gestionRuleta', [App\Http\Controllers\GestionRuletaController::class, 'index'])->name('gestionRuleta');
    Route::post('/savePremio', [App\Http\Controllers\GestionRuletaController::class, 'savePremio'])->name('savePremio');

    Route::get('/security', [App\Http\Controllers\SecurityController::class, 'index'])->name('security');
    Route::post('/saveRol', [App\Http\Controllers\SecurityController::class, 'saveRol'])->name('saveRol');
    Route::post('/verPermisos', [App\Http\Controllers\SecurityController::class, 'verPermisos'])->name('verPermisos');
    Route::post('/asignarPermisoRol', [App\Http\Controllers\SecurityController::class, 'asignarPermisoRol'])->name('asignarPermisoRol');

    Route::get('/perfilUsuario/{id}', [App\Http\Controllers\PerfilController::class, 'perfilUsuario'])->name('perfilUsuario');

});

