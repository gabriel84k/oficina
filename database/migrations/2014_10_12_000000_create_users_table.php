<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->text('profile_photo_path')->nullable();
            $table->boolean('estado')->default(1);
            $table->timestamps();

            /*[  Se crean las restricciones de clave externa -]*/
                $table->bigInteger('tipo_id')->unsigned()->index();
                $table->foreign('tipo_id')->references('id')->on('tipos');

                $table->bigInteger('cliente_id')->unsigned()->nullable()->index();
                $table->foreign('cliente_id')->references('id')->on('clientes');
                
                $table->bigInteger('empresa_id')->unsigned()->nullable()->index();
                $table->foreign('empresa_id')->references('id')->on('empresas');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
