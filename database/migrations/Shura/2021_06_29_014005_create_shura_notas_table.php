<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShuraNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shura_notas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->default(now());
            $table->string('titulo',100);
            $table->string('nota',255);
            $table->string('firma');
            $table->integer('estado')->default(1);
            $table->timestamps();

            /*[  Se crean las restricciones de clave externa -]*/
                $table->bigInteger('user_id')->unsigned()->index();
                $table->foreign('user_id')->references('id')->on('users');

                $table->bigInteger('cliente_id')->unsigned()->nullable()->index();
                $table->foreign('cliente_id')->references('id')->on('clientes');
              
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shura_notas');
    }
}
