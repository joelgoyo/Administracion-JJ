<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SuppliersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\BillingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//CLIENTES 
Route::prefix('clients')->group(function (){
    Route::post('/save', [ClientController::class, 'save']);
    Route::get('/list', [ClientController::class, 'list']);
    Route::delete('/delete/{id}', [ClientController::class, 'delete']);
    Route::put('/update/{id}', [ClientController::class, 'update']);
    Route::get('/check-email/{email}', [ClientController::class, 'checkEmail']);
    Route::get('/check-dni/{dni}', [ClientController::class, 'checkDni']);
    Route::post('/list-table', [ClientController::class, 'listTable']);
});

//PROVEEDORES
Route::prefix('suppliers')->group(function (){
    Route::post('/save', [SuppliersController::class, 'save']);
    Route::get('/list', [SuppliersController::class, 'list']);
    Route::get('/check-email/{email}', [SuppliersController::class, 'checkEmail']);
    Route::get('/check-name/{name}', [SuppliersController::class, 'checkName']);
    Route::delete('/delete/{id}', [SuppliersController::class, 'delete']);
    Route::put('/update/{id}', [SuppliersController::class, 'update']);
});

//PRODUCTOS
Route::prefix('products')->group(function (){
    Route::post('/save', [ProductsController::class, 'save']);
    Route::get('/list', [ProductsController::class, 'list']);
    Route::get('/check-code/{code}', [ProductsController::class, 'checkCode']);
    Route::get('/check-name/{name}', [ProductsController::class, 'checkName']);
    Route::delete('/delete/{id}', [ProductsController::class, 'delete']);
    Route::put('/update/{id}', [ProductsController::class, 'update']);
    Route::get('/count', [ProductsController::class, 'productsCount']);
});

//FACTURACION 
Route::prefix('billing')->group(function (){
    Route::get('/productsClients', [BillingController::class, 'index']);
});



Route::get('users', [UserController::class, 'index']);
