<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimulationDocIndic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulation_doc_indic', function (Blueprint $table) {
            $table->string('id', 25)->primary();
            $table->string('parent_id', 25);
            $table->foreign('parent_id')->references('id')->on('simulations_score')->onUpdate('cascade')->onDelete('cascade');
            $table->string('questions_indicator_id', 25);
            $table->foreign('questions_indicator_id')->references('id')->on('questions_indicators')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('simulation_doc_indic');
    }
}
