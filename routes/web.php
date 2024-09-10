<?php

use App\Http\Controllers\MailchimpController;
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

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('agents', [\App\Http\Controllers\AgentController::class, 'index'])->name('agents');
    Route::post('/saveAgent', [App\Http\Controllers\AgentController::class, 'saveAgent'])->name('saveAgent');
    Route::post('/searchAgent', [App\Http\Controllers\AgentController::class, 'searchAgent'])->name('searchAgent');
    Route::post('/updateAgent', [App\Http\Controllers\AgentController::class, 'updateAgent'])->name('updateAgent');
    Route::post('/cambiarEstadoAgente', [App\Http\Controllers\AgentController::class, 'cambiarEstadoAgente'])->name('cambiarEstadoAgente');
    Route::post('/eliminarAgente', [App\Http\Controllers\AgentController::class, 'eliminarAgente'])->name('eliminarAgente');
    Route::post('/saveNumberTurns', [App\Http\Controllers\AgentController::class, 'saveNumberTurns'])->name('saveNumberTurns');
    Route::post('/filterAgent', [App\Http\Controllers\AgentController::class, 'filterAgent'])->name('filterAgent');
    Route::post('/uploadImg', [App\Http\Controllers\AgentController::class, 'uploadImg'])->name('uploadImg');
    Route::post('/changePassword', [App\Http\Controllers\AgentController::class, 'changePassword'])->name('changePassword');
    Route::get('/agentsPagination', [App\Http\Controllers\AgentController::class, 'agentsPagination'])->name('agentsPagination');

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
    Route::post('/assignGroupAgent', [App\Http\Controllers\ClientsController::class, 'assignGroupAgent'])->name('assignGroupAgent');
    Route::get('/descargar-archivo', [App\Http\Controllers\ClientsController::class, 'descargarArchivo'])->name('descargarArchivo');
    Route::post('/uploadExcel', [App\Http\Controllers\ClientsController::class, 'uploadExcel'])->name('uploadExcel');
    Route::get('/profileClient/{id}', [App\Http\Controllers\ClientsController::class, 'profileClient'])->name('profileClient');
    Route::post('/saveConfigTable', [App\Http\Controllers\ClientsController::class, 'saveConfigTable'])->name('saveConfigTable');
    Route::get('/clientsPagination', [App\Http\Controllers\ClientsController::class, 'clientsPagination'])->name('clientsPagination');
    Route::post('/changeStatusGroup', [App\Http\Controllers\ClientsController::class, 'changeStatusGroup'])->name('changeStatusGroup');
    Route::post('/searchStatus', [App\Http\Controllers\ClientsController::class, 'searchStatus'])->name('searchStatus');
    Route::post('/filterOrder', [App\Http\Controllers\ClientsController::class, 'filterOrder'])->name('filterOrder');
    Route::post('/filterByAttr', [App\Http\Controllers\ClientsController::class, 'filterByAttr'])->name('filterByAttr');
    Route::post('/filterByDate', [App\Http\Controllers\ClientsController::class, 'filterByDate'])->name('filterByDate');

    Route::get('/sales', [App\Http\Controllers\SalesController::class, 'index'])->name('sales');
    Route::post('/searchCustomer', [App\Http\Controllers\SalesController::class, 'searchCustomer'])->name('searchCustomer');
    Route::post('/saveSale', [App\Http\Controllers\SalesController::class, 'saveSale'])->name('saveSale');
    Route::post('/updateSale', [App\Http\Controllers\SalesController::class, 'updateSale'])->name('updateSale');
    Route::post('/filterSales', [App\Http\Controllers\SalesController::class, 'filterSales'])->name('filterSales');
    Route::get('/obtener-datos-ventas', [App\Http\Controllers\SalesController::class, 'obtenerDatosVentas'])->name('obtenerDatosVentas');

    Route::get('/agentbonus', [App\Http\Controllers\AgentBonusController::class, 'index'])->name('agentBonus');
    Route::post('/saveBonus', [App\Http\Controllers\AgentBonusController::class, 'saveBonus'])->name('saveBonus');
    Route::post('/saveRetiro', [App\Http\Controllers\AgentBonusController::class, 'saveRetiro'])->name('saveRetiro');
    Route::post('/filterBonus', [App\Http\Controllers\AgentBonusController::class, 'filterBonus'])->name('filterBonus');

    Route::get('/statisticstoday', [App\Http\Controllers\StatisticsTodayController::class, 'index'])->name('statisticsToday');
    Route::post('/filterStatistics', [App\Http\Controllers\StatisticsTodayController::class, 'filterStatistics'])->name('filterStatistics');

    Route::get('/parttime', [App\Http\Controllers\PartTimeController::class, 'index'])->name('partTime');
    Route::post('/registerAssistance', [App\Http\Controllers\PartTimeController::class, 'registerAssistance'])->name('registerAssistance');
    Route::post('/filterAssistance', [App\Http\Controllers\PartTimeController::class, 'filterAssistance'])->name('filterAssistance');
    Route::get('/descargar-asistencia-pdf',  [App\Http\Controllers\PartTimeController::class, 'descargarReportePDF'])->name('descargar-asistencia-pdf');
    Route::get('/descargar-asistencia-excel', [App\Http\Controllers\PartTimeController::class, 'descargarReporteExcel'])->name('descargar-asistencia-excel');
    Route::post('/registerVacations', [App\Http\Controllers\PartTimeController::class, 'registerVacations'])->name('registerVacations');


    Route::post('/saveTarget', [App\Http\Controllers\TargetController::class, 'saveTarget'])->name('saveTarget');
    Route::post('/updateTarget', [App\Http\Controllers\TargetController::class, 'updateTarget'])->name('updateTarget');
    Route::post('/addTarget', [App\Http\Controllers\TargetController::class, 'addTarget'])->name('addTarget');

    Route::get('/gestionRuleta', [App\Http\Controllers\GestionRuletaController::class, 'index'])->name('gestionRuleta');
    Route::post('/savePremio', [App\Http\Controllers\GestionRuletaController::class, 'savePremio'])->name('savePremio');
    Route::post('/updateGiro', [App\Http\Controllers\GestionRuletaController::class, 'updateGiro'])->name('updateGiro');
    Route::post('/getPremio', [App\Http\Controllers\GestionRuletaController::class, 'getPremio'])->name('getPremio');

    Route::get('/security', [App\Http\Controllers\SecurityController::class, 'index'])->name('security');
    Route::post('/saveRol', [App\Http\Controllers\SecurityController::class, 'saveRol'])->name('saveRol');
    Route::post('/verPermisos', [App\Http\Controllers\SecurityController::class, 'verPermisos'])->name('verPermisos');
    Route::post('/asignarPermisoRol', [App\Http\Controllers\SecurityController::class, 'asignarPermisoRol'])->name('asignarPermisoRol');
    Route::post('/deletePermiso', [App\Http\Controllers\SecurityController::class, 'deletePermiso'])->name('deletePermiso');

    Route::get('/perfilUsuario/{id}', [App\Http\Controllers\PerfilController::class, 'perfilUsuario'])->name('perfilUsuario');

    Route::get('/task', [App\Http\Controllers\TaskController::class, 'index'])->name('task');
    Route::post('/guardarTask', [App\Http\Controllers\TaskController::class, 'guardarTask'])->name('guardarTask');
    Route::get('/obtenerEventos', [App\Http\Controllers\TaskController::class, 'obtenerEventos'])->name('obtenerEventos');
    Route::post('/saveEvent', [App\Http\Controllers\TaskController::class, 'saveEvent'])->name('saveEvent');
    Route::post('/getEventById', [App\Http\Controllers\TaskController::class, 'getEventById'])->name('getEventById');
    Route::post('/editEvent', [App\Http\Controllers\TaskController::class, 'editEvent'])->name('editEvent');
    Route::post('/deleteEvent', [App\Http\Controllers\TaskController::class, 'deleteEvent'])->name('deleteEvent');

    Route::get('/audit', [App\Http\Controllers\TaskController::class, 'index'])->name('audit');

    Route::post('/click-to-call', [App\Http\Controllers\VoisoController::class, 'clickToCall'])->name('clickToCall');
    Route::post('/initiateCall', [App\Http\Controllers\VoisoController::class, 'initiateCall'])->name('initiateCall');

    Route::get('/makeCall', [\App\Http\Controllers\CallController::class, 'makeCall'])->name('makeCall');

    Route::post('/saveComentario', [App\Http\Controllers\CommentController::class, 'saveComentario'])->name('saveComentario');

    Route::get('/whatsapp', [App\Http\Controllers\CommentController::class, 'whatsapp'])->name('whatsapp');
    Route::post('/whatsapp/chat', [App\Http\Controllers\CommentController::class, 'getChatDetails'])->name('getChatDetails');
    Route::post('/whatsapp/send', [App\Http\Controllers\CommentController::class, 'sendMessage'])->name('sendMessage');

    Route::get('/email', [App\Http\Controllers\CommentController::class, 'email'])->name('email');

    Route::get('/shooter', [App\Http\Controllers\ShooterController::class, 'index'])->name('shooter');
    Route::get('/administrarShoter', [App\Http\Controllers\ShooterController::class, 'administrarShoter'])->name('administrarShoter');
    Route::post('/viewFolder', [App\Http\Controllers\ShooterController::class, 'viewFolder'])->name('viewFolder');
    Route::post('/viewListClients', [App\Http\Controllers\ShooterController::class, 'viewListClients'])->name('viewListClients');
    Route::post('/viewResumClient', [App\Http\Controllers\ShooterController::class, 'viewResumClient'])->name('viewResumClient');

    Route::get('/deposit', [App\Http\Controllers\DepositController::class, 'index'])->name('deposit');
    Route::post('/deposit/save', [App\Http\Controllers\DepositController::class, 'saveDeposit'])->name('saveDeposit');

    Route::get('/maintenance', [App\Http\Controllers\MaintenanceController::class, 'index'])->name('maintenance');

    Route::post('/saveCustomerStatus', [App\Http\Controllers\CustomerStatusController::class, 'saveCustomerStatus'])->name('saveCustomerStatus');
    Route::post('/updateCustomerStatus', [App\Http\Controllers\CustomerStatusController::class, 'updateCustomerStatus'])->name('updateCustomerStatus');
    Route::post('/deleteCustomerStatus', [App\Http\Controllers\CustomerStatusController::class, 'deleteCustomerStatus'])->name('deleteCustomerStatus');

    Route::post('/saveCampaign', [App\Http\Controllers\CampaingController::class, 'saveCampaign'])->name('saveCampaign');
    Route::post('/updateCampaign', [App\Http\Controllers\CampaingController::class, 'updateCampaign'])->name('updateCampaign');
    Route::post('/deleteCampaign', [App\Http\Controllers\CampaingController::class, 'deleteCampaign'])->name('deleteCampaign');

    Route::post('/saveProvider', [App\Http\Controllers\ProviderController::class, 'saveProvider'])->name('saveProvider');
    Route::post('/updateProvider', [App\Http\Controllers\ProviderController::class, 'updateProvider'])->name('updateProvider');
    Route::post('/deleteProvider', [App\Http\Controllers\ProviderController::class, 'deleteProvider'])->name('deleteProvider');

    Route::post('/savePlatform', [App\Http\Controllers\PlatformController::class, 'savePlatform'])->name('savePlatform');
    Route::post('/updatePlatform', [App\Http\Controllers\PlatformController::class, 'updatePlatform'])->name('updatePlatform');
    Route::post('/deletePlatform', [App\Http\Controllers\PlatformController::class, 'deletePlatform'])->name('deletePlatform');

    Route::post('/saveTraiding', [App\Http\Controllers\TraidingController::class, 'saveTraiding'])->name('saveTraiding');
    Route::post('/updateTraiding', [App\Http\Controllers\TraidingController::class, 'updateTraiding'])->name('updateTraiding');
    Route::post('/deleteTraiding', [App\Http\Controllers\TraidingController::class, 'deleteTraiding'])->name('deleteTraiding');

    Route::post('/saveTransactionType', [App\Http\Controllers\TransactionTypeController::class, 'saveTransactionType'])->name('saveTransactionType');
    Route::post('/updateTransactionType', [App\Http\Controllers\TransactionTypeController::class, 'updateTransactionType'])->name('updateTransactionType');
    Route::post('/deleteTransactionType', [App\Http\Controllers\TransactionTypeController::class, 'deleteTransactionType'])->name('deleteTransactionType');

    Route::post('/deleteFolder', [App\Http\Controllers\FolderController::class, 'deleteFolder'])->name('deleteFolder');
    Route::post('/addGroupClientFolder', [App\Http\Controllers\FolderController::class, 'addGroupClientFolder'])->name('addGroupClientFolder');
    Route::post('/saveFolder', [App\Http\Controllers\FolderController::class, 'saveFolder'])->name('saveFolder');
    Route::post('/editFolder', [App\Http\Controllers\FolderController::class, 'editFolder'])->name('editFolder');
    Route::post('/addClientFolder', [App\Http\Controllers\FolderController::class, 'addClientFolder'])->name('addClientFolder');

    Route::get('/mail', [App\Http\Controllers\MailController::class, 'index'])->name('mail');
    Route::post('/enviar-correo-mailchimp', [MailchimpController::class, 'crearYEnviarCorreo'])->name('enviarCorreo');
});

