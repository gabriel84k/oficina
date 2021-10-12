<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamusLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camus_logs', function (Blueprint $table) {
            $table->id();
            $table->string('detalle',1400);
            $table->string('tipo');            
            $table->timestamps();
            /*[  Se crean las restricciones de clave externa -]*/
                $table->bigInteger('camus_user_id')->unsigned()->index();
                $table->foreign('camus_user_id')->references('id')->on('camus_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
