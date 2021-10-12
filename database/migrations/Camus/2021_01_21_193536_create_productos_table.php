<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camus_productos', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre')->nullabled();
            $table->string('Descripcion')->nullable();
            $table->string('Nro_Producto')->nullable();
            $table->double('Precio')->default(0);
            $table->boolean('Estado')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camus_productos');
    }
}
