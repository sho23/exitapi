<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExitSpotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_spot', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('exit_id')->unsigned();
            $table->integer('spot_id')->unsigned();
            $table->softDeletes();
            $table->foreign('exit_id')
                    ->references('id')
                    ->on('exits')
                    ->onDelete('cascade');
            $table->foreign('spot_id')
                    ->references('id')
                    ->on('spots')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exit_spot');
    }
}
