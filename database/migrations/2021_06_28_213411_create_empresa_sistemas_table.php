<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaSistemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_sistemas', function (Blueprint $table) {
            $table->id();

        /*[  Se crean las restricciones de clave externa -]*/
            $table->bigInteger('empresa_id')->unsigned()->index();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');

            $table->bigInteger('sistema_id')->unsigned()->index();
            $table->foreign('sistema_id')->references('id')->on('sistemas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa_sistemas');
    }
}
