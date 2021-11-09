<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reds', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('personal_id')->unsigned()->index();
            $table->foreign('personal_id')->references('id')->on('personals')->onDelete('cascade');
            
            $table->bigInteger('puesto_id')->unsigned()->index();
            $table->foreign('puesto_id')->references('id')->on('puestos')->onDelete('cascade');

            $table->bigInteger('tarea_id')->unsigned()->index();
            $table->foreign('tarea_id')->references('id')->on('tareas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reds');
    }
}
