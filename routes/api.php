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

Route::group(['prefix' => '/Conf'], function () {
    Route::get('/clear-cache', function() {
        $exitCode = Artisan::call('config:clear');
        $exitCode = Artisan::call('cache:clear');
        $exitCode = Artisan::call('config:cache');
        $exitCode = Artisan::call('optimize:clear');
        
        
        return 'Cache Borrado Correctamente!!'; 
    });
    Route::get('/down', function() {
      $exitCode = Artisan::call('down');
      
      return 'Sitio puesto en Mantención'; 
    });
    Route::get('/link', function() {
      $exitCode = Artisan::call('storage:link');
      
      return 'Crea link en public para storage.'; 
    });
  });