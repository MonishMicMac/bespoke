<?php

use App\Http\Controllers\api\AppBannerController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\SpotlightController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\SubCatController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('vendor/signup', [VendorController::class, 'store']);
Route::put('vendor/edit/{id}', [VendorController::class, 'update']);

Route::get('vendor/login', [VendorController::class, 'login']);

Route::post('user/signup', [UsersController::class, 'store']);
Route::put('user/edit/{id}', [UsersController::class, 'update']);

Route::get('user/login', [UsersController::class, 'login']);

Route::get('category/view', [CategoryController::class, 'view']);

Route::get('homepage/view', [AppBannerController::class, 'homepageview']);

Route::get('spotlight/view', [SpotlightController::class, 'spotlistview']);







