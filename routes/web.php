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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::get('agents', [\App\Http\Controllers\AgentController::class, 'index'])->name('agents');
Route::post('/saveAgent', [App\Http\Controllers\AgentController::class, 'saveAgent'])->name('saveAgent');
Route::post('/searchAgent', [App\Http\Controllers\AgentController::class, 'searchAgent'])->name('searchAgent');

Route::get('areas', [\App\Http\Controllers\AreaController::class, 'index'])->name('areas');
Route::post('/saveArea', [App\Http\Controllers\AreaController::class, 'saveArea'])->name('saveArea');

Route::get('/clients', [App\Http\Controllers\ClientsController::class, 'index'])->name('clients');
Route::post('/saveCustomer', [App\Http\Controllers\ClientsController::class, 'saveCustomer'])->name('saveCustomer');

Route::get('/sales', [App\Http\Controllers\SalesController::class, 'index'])->name('sales');
Route::post('/searchCustomer', [App\Http\Controllers\SalesController::class, 'searchCustomer'])->name('searchCustomer');
Route::post('/saveSale', [App\Http\Controllers\SalesController::class, 'saveSale'])->name('saveSale');

Route::get('/agentbonus', [App\Http\Controllers\AgentBonusController::class, 'index'])->name('agentBonus');
Route::post('/saveBonus', [App\Http\Controllers\AgentBonusController::class, 'saveBonus'])->name('saveBonus');
Route::post('/saveRetiro', [App\Http\Controllers\AgentBonusController::class, 'saveRetiro'])->name('saveRetiro');

Route::get('/statisticstoday', [App\Http\Controllers\StatisticsTodayController::class, 'index'])->name('statisticsToday');

Route::get('/parttime', [App\Http\Controllers\PartTimeController::class, 'index'])->name('partTime');

Route::post('/saveTarget', [App\Http\Controllers\TargetController::class, 'saveTarget'])->name('saveTarget');

Route::get('/gestionRuleta', [App\Http\Controllers\GestionRuletaController::class, 'index'])->name('gestionRuleta');
Route::post('/savePremio', [App\Http\Controllers\GestionRuletaController::class, 'savePremio'])->name('savePremio');

Route::get('/security', [App\Http\Controllers\SecurityController::class, 'index'])->name('security');
Route::post('/saveRol', [App\Http\Controllers\SecurityController::class, 'saveRol'])->name('saveRol');
Route::post('/verPermisos', [App\Http\Controllers\SecurityController::class, 'verPermisos'])->name('verPermisos');
Route::post('/asignarPermisoRol', [App\Http\Controllers\SecurityController::class, 'asignarPermisoRol'])->name('asignarPermisoRol');
