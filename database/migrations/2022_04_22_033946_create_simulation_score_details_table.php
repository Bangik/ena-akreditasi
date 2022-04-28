<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimulationScoreDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulation_score_details', function (Blueprint $table) {
            $table->string('id', 25)->primary();
            $table->string('parent_id', 25);
            $table->foreign('parent_id')->references('id')->on('simulations_score')->onUpdate('cascade')->onDelete('cascade');
            $table->string('component_questions_id', 25);
            $table->foreign('component_questions_id')->references('id')->on('components_questions')->onUpdate('cascade')->onDelete('cascade');
            $table->smallInteger('score')->nullable();
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
        Schema::dropIfExists('simulation_score_details');
    }
}
