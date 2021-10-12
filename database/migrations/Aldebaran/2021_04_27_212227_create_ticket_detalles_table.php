<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aldebaran_ticket_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo')->default(0);
            $table->string('titulo')->default('');
            $table->string('detalle')->default('');
            $table->timestamps();

            /*[  Se crean las restricciones de clave externa -]*/
                $table->bigInteger('tikect_id')->unsigned()->index();
                $table->foreign('tikect_id')->references('id')->on('tikects')->onDelete('cascade');

                $table->bigInteger('user_id')->unsigned()->nullable()->index();
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
        Schema::dropIfExists('aldebaran_ticket_detalles');
    }
}
