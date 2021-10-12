<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestodetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mu_presupuestodetalles', function (Blueprint $table) {
            $table->id();
            $table->string('detalle');
            $table->double('precio');
            $table->double('cantidad');
            $table->double('total');

            /*[  Se crean las restricciones de clave externa -]*/
            $table->bigInteger('presupuesto_id')->unsigned()->index();
            $table->foreign('presupuesto_id')->references('id')->on('mu_presupuestos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mu_presupuestodetalles');
    }
}
