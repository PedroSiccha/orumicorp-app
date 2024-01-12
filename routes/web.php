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

Route::get('/clients', [App\Http\Controllers\ClientsController::class, 'index'])->name('clients');

Route::get('/sales', [App\Http\Controllers\SalesController::class, 'index'])->name('sales');

Route::get('/agentbonus', [App\Http\Controllers\AgentBonusController::class, 'index'])->name('agentBonus');

Route::get('/statisticstoday', [App\Http\Controllers\StatisticsTodayController::class, 'index'])->name('statisticsToday');

Route::get('/parttime', [App\Http\Controllers\PartTimeController::class, 'index'])->name('partTime');
