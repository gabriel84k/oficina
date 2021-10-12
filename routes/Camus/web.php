<?php

use Illuminate\Support\Facades\Route;

#---------------------- Sistema  CtasCtes (Camus)---------------------------#
Route::group(['prefix' => '/Camus'], function () {
    Route::group(['prefix' => '/cliente'], function () {
        Route::resource('/data', App\Http\Controllers\Camus\ClienteController::class)->name('*','cliente');
        Route::get('/showproductocliente/{id}',[App\Http\Controllers\Camus\ClienteController::class,'showproductocliente']);
        Route::get('/orden/{zona}', [App\Http\Controllers\Camus\ClienteController::class, 'orden']);
        
        Route::get('/combozona', [App\Http\Controllers\Camus\ClienteController::class,'combozona']);
       
    });
    Route::group(['prefix' => '/producto'], function () {
        Route::resource('/data', App\Http\Controllers\Camus\ProductoController::class)->name('*','producto');
        
        Route::get('/comboproducto',[App\Http\Controllers\Camus\ProductoController::class,'comboproducto'])->name('*','comboproducto');
    });
    Route::group(['prefix' => '/ctacte'], function () {
        Route::resource('/data', App\Http\Controllers\Camus\CtacteController::class)->name('*','ctacte');
        //Route::get('/{id}', [App\Http\Controllers\Camus\CtacteController::class, 'show']);
    });
    Route::group(['prefix' => '/ctactedetalle'], function () {
        Route::resource('/data', App\Http\Controllers\Camus\CtacteDetalleController::class)->name('*','ctactedetalle');
        Route::post('/data/PagoRapido/{id_cobrador}', [App\Http\Controllers\Camus\CtacteDetalleController::class,'storePagoRapido']);
        
        
    });
    Route::group(['prefix' => '/Users'], function () {
        Route::resource('/data', App\Http\Controllers\Camus\UserController::class)->name('*','User');
        Route::get('/combovendedor', [App\Http\Controllers\Camus\UserController::class,'combovendedor']);
        Route::get('/combocobrador', [App\Http\Controllers\Camus\UserController::class,'combocobrador']);
        Route::get('/combotipo', [App\Http\Controllers\Camus\UserController::class,'combotipo']);
        Route::get('/combozona', [App\Http\Controllers\Camus\UserController::class,'combozona']);
        
    });
    Route::group(['prefix' => '/util'], function () {
        Route::group(['prefix' => '/cliente'], function () {
            Route::get('/filtrado', [App\Http\Controllers\Camus\ClienteController::class,'filtrado']);
            Route::get('/filtradoConProducto', [App\Http\Controllers\Camus\ClienteController::class,'filtradoConProducto']);
        });
        Route::group(['prefix' => '/producto'], function () {
            Route::get('/filtrado', [App\Http\Controllers\Camus\ProductoController::class,'filtrado']);
            Route::get('/filtradoConCliente', [App\Http\Controllers\Camus\ProductoController::class,'filtradoConCliente']);
            
        });
        Route::group(['prefix' => '/ctacte'], function () {
            Route::get('/filtrado', [App\Http\Controllers\Camus\CtacteController::class,'filtrado']);
            Route::get('/filtradocliente', [App\Http\Controllers\Camus\CtacteController::class,'filtradocliente']);
            Route::get('/filtrobotones', [App\Http\Controllers\Camus\CtacteController::class,'filtrobotones']);
            
        });
        Route::group(['prefix' => '/Users'], function () {
            Route::get('/filtrado', [App\Http\Controllers\Camus\UserController::class,'filtrado']);
            
        });
        Route::group(['prefix' => '/Zona'], function () {
            Route::get('/combozona', [App\Http\Controllers\Camus\ZonaController::class,'combozona']);
            Route::resource('/data', App\Http\Controllers\Camus\ZonaController::class)->name('*','Zona');;
            
        });
        Route::group(['prefix' => '/Log'], function () {
            Route::get('/filtrado', [App\Http\Controllers\Camus\LogController::class,'filtrado']);
        });
    });
    Route::group(['prefix' => '/PDF'], function () {
        Route::get('/listadocliente', [App\Http\Controllers\Camus\PrintController::class,'listadocliente']);
        Route::get('/listadocobrador', [App\Http\Controllers\Camus\PrintController::class,'listadocobrador']);
        Route::get('/listadocobranza', [App\Http\Controllers\Camus\PrintController::class,'listadocobranza']);
        Route::get('/listadocxcobrador/{id}', [App\Http\Controllers\Camus\PrintController::class,'listadocxcobrador']);
        Route::get('/listadorentabilidad/{desde}/{hasta}', [App\Http\Controllers\Camus\PrintController::class,'listadorentabilidad']);
    });
    Route::group(['prefix' => '/log'], function () {
        Route::resource('/data', App\Http\Controllers\Camus\LogController::class)->name('*','log');
    });
});
