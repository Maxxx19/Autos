<?php

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

// Sample API route
Route::get('/profits', [\App\Http\Controllers\SampleDataController::class, 'profits'])->name('profits');
Route::post('/createAuto', [\App\Http\Controllers\Api\CreateAutoController::class, 'createAuto'])->name('createAuto');
Route::get('/getAutos', [\App\Http\Controllers\Api\AutosController::class, 'getAutos'])->name('getAutos');
Route::post('/editAuto', [\App\Http\Controllers\Api\AutosController::class, 'editAuto'])->name('editAuto');
Route::post('/deleteAuto', [\App\Http\Controllers\Api\AutosController::class, 'deleteAuto'])->name('deleteAuto');
Route::post('/brandList', [\App\Http\Controllers\Api\AutosController::class, 'brandList'])->name('brandList');