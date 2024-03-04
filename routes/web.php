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
Route::post('instalar_docker/{grupo_id}/{vps_id}', [\App\Http\Controllers\VpsController::class, 'instalar_docker'])->name('instalar_docker');




