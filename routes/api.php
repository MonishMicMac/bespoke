<?php

use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\VendorController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('vendor/signup', [VendorController::class, 'store']);
Route::put('vendor/edit/{id}', [VendorController::class, 'update']);

Route::post('user/signup', [UsersController::class, 'store']);
Route::put('user/edit/{id}', [UsersController::class, 'update']);