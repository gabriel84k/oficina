<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpedientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->integer('año');
            $table->string('caratula');            
            $table->long('codigoTramite')->nullable();            
            $table->string('codigoArchivado')->nullable();            
            $table->date('fechaCreacion');            
            $table->date('fechaArchivado')->nullable();            
            $table->string('foto')->nullable();            
            $table->boolean('estado');       
            $table->timestamps();

            # [ Se crean las restricciones de clave externa ] #
            $table->bigInteger('empresa_id')->unsigned()->index();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expedientes');
    }
}
