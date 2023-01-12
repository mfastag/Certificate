<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\ChartController::class, 'doDash'])->middleware('auth');
Route::get('/home',function (Request $request) {  return redirect('/'); });

Route::get('/chemical', [App\Http\Controllers\ChemicalController::class, 'index'])->middleware('auth');
//Route::get('/chemical/totalUsage', [App\Http\Controllers\ChemicalController::class, 'totalUsage']);
//Route::get('/chemical/totalUsageChart', [App\Http\Controllers\ChemicalController::class, 'totalUsageChart']);

Route::get('/facility', [App\Http\Controllers\FacilityController::class, 'index'])->middleware('auth');



Route::get('/exception', [App\Http\Controllers\ExceptionController::class, 'index'])->middleware('auth');
Route::get('/exception/ByType', [App\Http\Controllers\ExceptionController::class, 'getExceptionsByType']);
Route::get('/exception/ByLine', [App\Http\Controllers\ExceptionController::class, 'getExceptionsByLine']);
Route::get('/exception/ByObject', [App\Http\Controllers\ExceptionController::class, 'getExceptionsByObject']);
Route::get('/exception/TopByObject', [App\Http\Controllers\ExceptionController::class, 'getTopEquipmentExceptions']);

Route::get('/inventory', [App\Http\Controllers\InventoryController::class, 'index'])->middleware('auth');
Route::get('/inventory/getList', [App\Http\Controllers\InventoryController::class, 'getInventory']);
Route::post('/inventory/saveLog', [App\Http\Controllers\InventoryController::class, 'saveLog']);

Route::get('/inventory/dos', [App\Http\Controllers\InventoryController::class, 'dosIndex'])->middleware('auth');
Route::get('/inventory/getDos', [App\Http\Controllers\InventoryController::class, 'getDos']);

Route::get('/inventory/dosG', [App\Http\Controllers\InventoryController::class, 'dosIndexG'])->middleware('auth');
Route::get('/inventory/getDosG', [App\Http\Controllers\InventoryController::class, 'getDosGuages']);
//Route::post('/inventory/checkMaterialCode', [App\Http\Controllers\InventoryController::class, 'barcodeCheckMaterialCode']);
Route::post('/inventory/postInventory', [App\Http\Controllers\InventoryController::class, 'barcodePostInventory']);

Route::get('/active', [App\Http\Controllers\ActiveController::class, 'index'])->middleware('auth');
Route::get('/activeData', [App\Http\Controllers\ActiveController::class, 'getActive']); // API
Route::get('/activeColors', [App\Http\Controllers\ActiveController::class, 'getColors']); // API

Route::get('/cip', [App\Http\Controllers\CipController::class, 'index'])->middleware('auth');
Route::get('/cip/detail', [App\Http\Controllers\CipController::class, 'getDetail']);

Route::get('/hist', function () { return view('history');});


Route::get('/test', function () {
    return view('test');
});


Route::get('/data1', [App\Http\Controllers\ChartController::class, 'getData1']);
Route::get('/plot', [App\Http\Controllers\ChartController::class, 'plotly']);
Route::get('/dash', [App\Http\Controllers\ChartController::class, 'doDash']);
Route::get('/charts', [App\Http\Controllers\ChartController::class, 'doDash']);
Route::get('/expDashPie', [App\Http\Controllers\ChartController::class, 'getDashExceptionPieChart']);
Route::get('/expDashTrend', [App\Http\Controllers\ChartController::class, 'getDashChemicalTrendChart']);
Route::get('/totalsDashTrend', [App\Http\Controllers\ChartController::class, 'getDashTotalsTrendChart']);

Route::get('/inventory', [App\Http\Controllers\InventoryController::class, 'index'])->middleware('auth');
Route::get('/barcode', function () { return view('barcode'); })->middleware('auth');


//Route::get('/chart1_data', [App\Http\Controllers\ChartController::class, 'chart1_data']);
//Route::get('/chart2_data', [App\Http\Controllers\ChartController::class, 'chart2_data']);
//Route::get('/chart3_data', [App\Http\Controllers\ChartController::class, 'chart3_data']);
//Route::get('/chart4_data', [App\Http\Controllers\ChartController::class, 'chart4_data']);


//Route::get('/home', [App\Http\Controllers\SearchController::class, 'index']);

Route::get('/about', function () {
    return view('about_us');
});

Route::get('/logout',function (Request $request) {
    Auth::logout();
    return redirect('/');
});




Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

//Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm');//->middleware('auth');;

//Auth::routes();
//Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');//->middleware('auth');;
//Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');//->middleware('auth');;
//Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');//;;

