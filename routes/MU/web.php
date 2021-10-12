<?php

use Illuminate\Support\Facades\Route;

#---------------------- Sistema  Presupuesto (MU)---------------------------#
Route::group(['prefix' => '/MU'], function () {
    Route::group(['prefix' => '/Presupuesto'], function () {
        Route::resource('/data', App\Http\Controllers\MU\PresupuestoController::class)->name('*','presupuesto');
       
    });
});
