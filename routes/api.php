<?php

use App\Http\Controllers\FloorsController;
use App\Http\Controllers\GaragesController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\authController;
use App\Models\garages;
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


Route::post('register',[authController::class,'register']);
Route::post('login',[authController::class,'login']);


Route::group(['middleware'=>["auth:sanctum"]],function(){
    
});
Route::resource('garages',GaragesController::class);
    Route::resource('floors',FloorsController::class);
    Route::resource('places',PlacesController::class);
    
    Route::get('/floors/showByGarage/{garageId}', [FloorsController::class, 'showByGarage']);
    Route::get('/places/showByGarage/{garageId}', [PlacesController::class, 'showByGarage']);
    Route::get('/places/showByFloor/{floorId}', [PlacesController::class, 'showByFloor']);
    Route::get('/garages/getImage/{garageId}', [GaragesController::class, 'getImage']);
    Route::get('/garages/updateImage/{garageId}', [GaragesController::class, 'updateImage']);

    Route::post('/logout',[authController::class,'logout']);