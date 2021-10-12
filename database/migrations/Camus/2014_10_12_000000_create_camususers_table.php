<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamusUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camus_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('estado')->default(1);
            $table->timestamps();

             /*[  Se crean las restricciones de clave externa -]*/
                $table->bigInteger('camus_tipo_id')->unsigned()->index();
                $table->foreign('camus_tipo_id')->references('id')->on('camus_tipos');
                $table->bigInteger('user_id')->unsigned()->index();
                
            /*[  Relacion con la tabla padre -]*/
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
        Schema::dropIfExists('camus_users');
    }
}
