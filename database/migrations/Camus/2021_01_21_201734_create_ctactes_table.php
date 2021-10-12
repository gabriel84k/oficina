<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCtactesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camus_ctactes', function (Blueprint $table) {
            $table->id();
            $table->date('Fecha_Compra');
            $table->double('Total')->default(0);
            $table->double('Resto')->default(0);
            $table->double('MontoCuota')->default(0);
            $table->double('Entrega')->default(0);
            $table->integer('Cuotas')->default(0);
            $table->integer('Resto_Cuotas')->default(0);
            $table->string('Financiacion')->default('')->nullable();
            $table->integer('Porcentaje')->default(0)->nullable();

            $table->timestamps();

            /*[  Se crean las restricciones de clave externa -]*/
                $table->bigInteger('camus_producto_id')->unsigned()->index();
                $table->foreign('camus_producto_id')->references('id')->on('camus_productos');
                
                $table->bigInteger('camus_cliente_id')->unsigned()->index();
                $table->foreign('camus_cliente_id')->references('id')->on('camus_clientes');

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
        Schema::dropIfExists('camus_ctactes');
    }
}
