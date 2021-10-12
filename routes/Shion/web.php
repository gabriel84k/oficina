<?php

use Illuminate\Support\Facades\Route;

#---------------------- Sistema  Turnos (Shion)---------------------------#
Route::group(['prefix' => '/Shion'], function () {
    Route::group(['prefix' => '/Turnos'], function () {
        #-[Get]:
        
        #-[Resource]:
        Route::resource('/data', App\Http\Controllers\Shion\TurnosController::class)->name('*','Turnos');
    });

});

