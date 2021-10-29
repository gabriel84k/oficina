<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reds', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('personal_id')->unsigned()->index();
            $table->foreign('personal_id')->references('id')->on('personals')->onDelete('cascade');
            
            $table->bigInteger('spt_id')->unsigned()->index();
            $table->foreign('spt_id')->references('id')->on('spt')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reds');
    }
}
