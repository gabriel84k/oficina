<?php

use Illuminate\Support\Facades\Route;

#---------------------- Sistema  Turnos (Shion)---------------------------#
Route::group(['prefix' => '/Shura'], function () {
    Route::group(['prefix' => '/Nota'], function () {
        #-[Get]:
        
        #-[Resource]:
        Route::resource('/data', App\Http\Controllers\Shura\NotaController::class)->name('*','Nota');
    });

});

