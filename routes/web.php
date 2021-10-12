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
    return view('auth.login');
    
})->middleware(['verified']);

Route::group(['prefix' => '/home','middleware' => ['verified']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => '/Users'], function () {
        Route::resource('/data', App\Http\Controllers\UserController::class)->name('*','User');
       
        Route::get('/combotipo', [App\Http\Controllers\UserController::class,'combotipo']);
        Route::get('/combomedicos', [App\Http\Controllers\UserController::class,'combomedicos']);
    });


    require __DIR__ . '/Aldebaran/web.php';
    require __DIR__ . '/Shion/web.php';
    require __DIR__ . '/Camus/web.php';
    require __DIR__ . '/MU/web.php';
    require __DIR__ . '/Shura/web.php';
    require __DIR__ . '/Ikki/web.php';
    Route::post('/logout', 'API\AuthController@logout');
});