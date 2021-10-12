<?php

use Illuminate\Support\Facades\Route;

#---------------------- Sistema  Ticket (Aldebaran)---------------------------#
Route::group(['prefix' => '/Aldebaran'], function () {
    Route::group(['prefix' => '/Ticket'], function () {
        Route::resource('/data', App\Http\Controllers\Aldebaran\TicketController::class)->name('*','Ticket');
        Route::post('/storeDetalleTicket/{id}', [App\Http\Controllers\Aldebaran\TicketController::class,'storeDetalleTicket'])->name('*','storeDetalleTicket');
        Route::post('/storeTicket/{id}', [App\Http\Controllers\Aldebaran\TicketController::class,'storeTicket'])->name('*','storeTicket');
        
        Route::group(['prefix' => '/util'], function () {
            Route::get('/filtrado', [App\Http\Controllers\Aldebaran\TicketController::class,'filtrado'])->name('*','filtrado');
            Route::get('/filtradoBoton', [App\Http\Controllers\Aldebaran\TicketController::class,'filtradoBoton'])->name('*','filtradoBoton');
        });

    });
    Route::group(['prefix' => '/Sistema'], function () {
        Route::resource('/data', App\Http\Controllers\Aldebaran\SistemaController::class)->name('*','Sistema');
       
    });
    Route::group(['prefix' => '/Cliente'], function () {
        Route::resource('/data', App\Http\Controllers\Aldebaran\ClienteController::class)->name('*','Cliente');
       
    });
});