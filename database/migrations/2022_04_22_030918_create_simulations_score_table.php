<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimulationsScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulations_score', function (Blueprint $table) {
            $table->string('id', 25)->primary();
            $table->string('parent_id', 25);
            $table->foreign('parent_id')->references('id')->on('simulations')->onUpdate('cascade')->onDelete('cascade');
            $table->string('scoretype_component_id', 25);
            $table->foreign('scoretype_component_id')->references('id')->on('scoretype_components')->onUpdate('cascade')->onDelete('cascade');
            $table->smallInteger('score')->nullable();
            $table->smallInteger('score_max')->nullable();
            $table->datetime('created_on')->nullable();
            $table->datetime('modified_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simulations_score');
    }
}
