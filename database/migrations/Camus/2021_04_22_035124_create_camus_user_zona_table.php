<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamusUserZonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camus_users_zonas', function (Blueprint $table) {
            $table->bigIncrements('id');
          
            $table->bigInteger('camus_user_id')->unsigned()->nullable()->index();
            $table->foreign('camus_user_id')->references('id')->on('camus_users')->onDelete('cascade');;

            $table->bigInteger('camus_zona_id')->unsigned()->nullable()->index();
            $table->foreign('camus_zona_id')->references('id')->on('camus_zonas')->onDelete('cascade');;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camus_users_zonas');
    }
}
