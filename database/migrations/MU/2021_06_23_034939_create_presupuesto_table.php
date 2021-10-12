<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mu_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->default(now());
            $table->string('direccion');
            $table->string('titulo');
            $table->double('total')->default(0.0);
            $table->string('nota');
            $table->string('firma');
            $table->integer('estado');
            $table->timestamps();

            /*[  Se crean las restricciones de clave externa -]*/
                $table->bigInteger('cliente_id')->unsigned()->nullable()->index();
                $table->foreign('cliente_id')->references('id')->on('clientes');
                $table->bigInteger('user_id')->unsigned()->index();
                $table->foreign('user_id')->references('id')->on('users');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mu_presupuestos');
    }
}
