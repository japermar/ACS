<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
