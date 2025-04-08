<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/login', function () {
    return view('login');
});

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::group(["middleware" => "auth"], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/logout', function () {
        auth()->logout();
        
        return redirect()->route('login');
    });
    Route::get('/billing', function () {
        return view('welcome');
    });
    Route::get('/supplier-registration', function () {
        return view('welcome');
    });
    Route::get('/customer-registration', function () {
        return view('welcome');
    });
    Route::get('/accounting', function () {
        return view('welcome');
    });
    Route::get('/add-products', function () {
        return view('welcome');
    });
    Route::get('/edit-products', function () {
        return view('welcome');
    });
    Route::get('/income', function () {
        return view('welcome');
    });
    Route::get('/expenses', function () {
        return view('welcome');
    });
    Route::get('/sales', function () {
        return view('welcome');
    });
});


Route::get('/home', [HomeController::class, 'index']);