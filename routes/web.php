<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VpsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return ('<p>Test htmx </p>');
});

use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

Route::get('/send-test-email', function () {
    $to = 'test@example.com'; // The recipient of the email
    Mail::to($to)->send(new TestEmail());

    return 'Email sent successfully!';
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/grupo/{group_id}', [VpsController::class, 'index'])->name('ver_grupo');
Route::get('/administrar/{grupo_id}', [\App\Http\Controllers\AdministrarGrupo::class, 'index'])->name('administrar_grupo');
Route::get('/grupo/{group_id}/vps/{vps_id}', [\App\Http\Controllers\EspecificoController::class, 'index'])->name('especifico');
Route::get('/administrar/{grupo_id}/vps/{vps_id}', [\App\Http\Controllers\VpsController::class, 'monitorizar'])->name('monitorizar_vps');
Route::post('/monitorizar/{grupo_id}/{vps_id}', [\App\Http\Controllers\EspecificoController::class, 'monitorizar'])->name('monitorizar');
Route::post('administrar/invitar/{grupo_id}/', [\App\Http\Controllers\AdministrarGrupo::class, 'invitar'])->name('invitar');
Route::post('administrar/eliminar/{grupo_id}/', [\App\Http\Controllers\AdministrarGrupo::class, 'eliminar'])->name('eliminar');
Route::post('revisar_docker/{grupo_id}/{vps_id}', [\App\Http\Controllers\VpsController::class, 'revisar_docker'])->name('revisar_docker');
Route::post('instalar_docker/{grupo_id}/{vps_id}', [\App\Http\Controllers\VpsController::class, 'instalar_docker'])->name('instalar_docker');
Route::post('desinstalar_docker/{grupo_id}/{vps_id}', [\App\Http\Controllers\VpsController::class, 'desinstalar_docker'])->name('desinstalar_docker');
Route::post('servicios_docker/{grupo_id}/{vps_id}', [\App\Http\Controllers\VpsController::class, 'servicios_docker'])->name('servicios_docker');
Route::post('anadir_vps/{grupo_id}', [\App\Http\Controllers\VpsController::class, 'anadir'])->name('anadir_vps');
Route::post('/instalar_servicio/{grupo_id}/vps/{vps_id}/{servicio}', [\App\Http\Controllers\VpsController::class, 'instalar_servicio_docker'])->name('instalar_servicio');
Route::post('/ver_imagenes/{grupo_id}/vps/{vps_id}', [\App\Http\Controllers\VpsController::class, 'imagenes_instaladas'])->name('imagenes');
Route::post('/administrar_servicios/{grupo_id}/vps/{vps_id}', [\App\Http\Controllers\VpsController::class, 'administrar_servicio'])->name('administrar_servicios');
Route::post('/encender/{grupo_id}/vps/{vps_id}', [\App\Http\Controllers\VpsController::class, 'encender_servicio'])->name('encender_servicios');
Route::post('/apagar/{grupo_id}/vps/{vps_id}', [\App\Http\Controllers\VpsController::class, 'apagar_servicio'])->name('apagar_servicios');
Route::get('/asistente/{grupo_id}/vps/{vps_id}', [\App\Http\Controllers\VpsController::class, 'ia'])->name('asistente');
Route::post('/hablar_asistente', [\App\Http\Controllers\VpsController::class, 'hablar'])->name('hablar_asistente');




