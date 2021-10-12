<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbunesGaleriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ikki_albunes_galerias', function (Blueprint $table) {

            $table->id();
            /*[  Se crean las restricciones de clave externa -]*/
             $table->bigInteger('albun_id')->unsigned()->index();
             $table->foreign('albun_id')->references('id')->on('ikki_albunes');
 
             $table->bigInteger('galeria_id')->unsigned()->index();
             $table->foreign('galeria_id')->references('id')->on('ikki_galerias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ikki_albunes_galerias');
    }
}
