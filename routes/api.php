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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->get('/chemical/totalUsage', [App\Http\Controllers\ChemicalController::class, 'totalUsage']);
Route::middleware('auth:api')->get('/chemical/totalUsageChart', [App\Http\Controllers\ChemicalController::class, 'totalUsageChart']);

Route::middleware('auth:api')->get('/facility/totalUsage', [App\Http\Controllers\FacilityController::class, 'totalUsage']);
Route::middleware('auth:api')->get('/facility/totalUsageChart', [App\Http\Controllers\FacilityController::class, 'totalUsageChart']);

Route::post('/inventory/checkMaterialCode', [App\Http\Controllers\InventoryController::class, 'barcodeCheckMaterialCode']);

Route::get('/whistory', [App\Http\Controllers\ChartController::class, 'getHistoryTable']);
