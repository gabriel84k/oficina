<?php

use Illuminate\Support\Facades\Route;

#---------------------- Sistema  Turnos (Shion)---------------------------#
Route::group(['prefix' => '/Shaka'], function () {
    Route::group(['prefix' => '/Red'], function () {
        Route::group(['prefix' => '/Sector'], function () {
            #-[Get]:
            
            #-[Resource]:
            Route::resource('/data', App\Http\Controllers\Shaka\SectorController::class)->name('*','index');
        });
    });

});

