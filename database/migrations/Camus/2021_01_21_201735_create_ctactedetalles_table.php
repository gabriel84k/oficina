<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCtactedetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camus_ctactedetalles', function (Blueprint $table) {
            $table->id();
            $table->date('Fecha');
            $table->double('Pago')->default(0)->nullable();
            $table->string('Detalle')->nullable();
            
            $table->timestamps();
                
            /*[  Se crean las restricciones de clave externa -]*/
                $table->bigInteger('camus_ctacte_id')->unsigned()->index();
                $table->foreign('camus_ctacte_id')->references('id')->on('camus_ctactes');
                
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
        Schema::dropIfExists('camus_ctactedetalles');
    }
}
