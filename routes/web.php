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

Route::get('/', function () {
    return redirect('login');
});



// HerOku

// Instance Statu
route::get('serverStatu/', [App\Http\Controllers\ServerController::class, 'serverStatu'])->name('serverStatu');
route::get('clientStatu/', [App\Http\Controllers\ClientController::class, 'clientStatu'])->name('clientStatu');


// Instance IP
route::get('serverIp/', [App\Http\Controllers\ServerController::class, 'serverIp'])->name('serverIp');
route::get('clientIp/', [App\Http\Controllers\ClientController::class, 'clientIp'])->name('clientIp');



route::get('twitterUserTimeLine/', [App\Http\Controllers\HerOkuController::class, 'twitterUserTimeLine'])->name('twitterUserTimeLine');


route::get('description1/', [App\Http\Controllers\ClientController::class, 'description'])->name('description1');










// Server
route::get('serverStart/', [App\Http\Controllers\ServerController::class, 'serverStart'])->name('serverStart');
route::get('serverStop/', [App\Http\Controllers\ServerController::class, 'serverStop'])->name('serverStop');













// Client
route::get('clientStart/', [App\Http\Controllers\ClientController::class, 'clientStart'])->name('clientStart');
route::get('clientStop/', [App\Http\Controllers\ClientController::class, 'clientStop'])->name('clientStop');












Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Register
Route::get('register-index', [App\Http\Controllers\HomeController::class, 'registerIndex'])->name('register.index');
Route::post('register-index-update/{id}', [App\Http\Controllers\HomeController::class, 'registerIndexUpdate'])->name('register.index.update');

