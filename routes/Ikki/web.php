<?php

use Illuminate\Support\Facades\Route;

#---------------------- Sistema  Galeria Imágenes (Ikki)---------------------------#
Route::group(['prefix' => '/Ikki'], function () {
    Route::group(['prefix' => '/Galeria'], function () {
        #-[Get]:
        
        #-[Resource]:
        Route::resource('/data', App\Http\Controllers\Ikki\GaleriaController::class)->name('*','Galeria');
    });
    Route::group(['prefix' => '/Albun'], function () {
        #-[Get]:
        
        #-[Resource]:
        Route::resource('/data', App\Http\Controllers\Ikki\AlbunController::class)->name('*','Albun');
    });


});

