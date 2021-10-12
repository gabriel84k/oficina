<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamusPermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camus_permisos', function (Blueprint $table) {
            $table->id();
            $table->string('menu')->default('');
            $table->string('cliente')->default('');
            $table->string('usuario')->default('');
            $table->string('producto')->default('');
            $table->string('reporte')->default('');
            $table->string('config')->default('');
            
                $table->bigInteger('camus_user_id')->unsigned()->index();
                $table->foreign('camus_user_id')->references('id')->on('camus_users');

                $table->bigInteger('permiso_id')->unsigned()->index();
                $table->foreign('permiso_id')->references('id')->on('permisos');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camus_permisos');
    }
}
