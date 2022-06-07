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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',

], function ($router) {

    // Instance statu   
    route::get('serverStatu/', [App\Http\Controllers\ServerController::class, 'serverStatu'])->name('serverStatu');
    route::get('clientStatu/', [App\Http\Controllers\ClientController::class, 'clientStatu'])->name('clientStatu');

    
    // Instance IP
    route::get('serverIp/', [App\Http\Controllers\ServerController::class, 'serverIp'])->name('serverIp');
    route::get('clientIp/', [App\Http\Controllers\ClientController::class, 'clientIp'])->name('clientIp');


	// get Server API from Server
    route::get('getServerIpFromServer/{ip}', [App\Http\Controllers\ServerController::class, 'getServerIpFromServer'])->name('getServerIpFromServer');

    // get Server API from Server
    route::get('getServerIpFromHerOku', [App\Http\Controllers\ClientController::class, 'getServerIpFromHerOku'])->name('getServerIpFromHerOku');

  
    Route::get('getTweetsFromServer', [App\Http\Controllers\HerOkuController::class, 'getTweetsFromServer'])->name('getTweetsFromServer');





});