<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamusClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camus_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre_Apellido',100);
            $table->string('Domicilio',200)->nullable();
            $table->string('Localidad',100)->nullable();
            $table->integer('Dni')->nullable();
            $table->integer('Orden')->nullable()->default(0);
            $table->string('Observaciones')->nullable();  
            $table->string('vendedor',200)->nullable();   
            $table->string('dia',20);  
            $table->boolean('Estado')->default(1);            
            $table->timestamps();

            /*[  Se crean las restricciones de clave externa -]*/
                $table->bigInteger('camus_zona_id')->unsigned()->index();
                $table->foreign('camus_zona_id')->references('id')->on('camus_zonas');

                $table->bigInteger('camus_user_id')->unsigned()->nullable()->index();
                $table->foreign('camus_user_id')->references('id')->on('camus_users');
                
            /*[  Relacion con la tabla padre -]*/
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
        Schema::dropIfExists('camus_clientes');
    }
}
