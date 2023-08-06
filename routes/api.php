<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
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

// Route::resource('products', ProductController::class);

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/stores', [StoreController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/stores', [StoreController::class, 'store']);
    Route::put('/stores/{id}', [StoreController::class, 'update']);
    Route::delete('/stores/{id}', [StoreController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/stores/searchbyusers', [StoreController::class, 'searchbyusers']);
    Route::get('/products/searchbystore', [ProductController::class, 'searchbystore']);
    Route::get('/stores/{id}', [StoreController::class, 'show']);
    Route::get('/stores/search/{name}', [StoreController::class, 'search']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/products/search/{name}', [ProductController::class, 'search']);
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});