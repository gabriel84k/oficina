<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->id();
            $table->string('menu')->default('');
            $table->string('ticket')->default('');
            $table->string('usuario')->default('');
            $table->string('cliente')->default('');
            $table->string('calendario')->default('');
            $table->string('ctacte')->default('');
            $table->string('presupuesto')->default('');
            $table->string('nota')->default('');
            $table->string('galeria')->default('');
            $table->string('config')->default('');
            $table->string('sistema')->default('');
            
            
                $table->bigInteger('user_id')->unsigned()->index();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}
