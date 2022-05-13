<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulations', function (Blueprint $table) {
            $table->string('id', 25)->primary();
            $table->smallInteger('total_score')->nullable();
            $table->smallInteger('total_score_max')->nullable();
            $table->smallInteger('score_doc')->nullable();
            $table->smallInteger('score_doc_max')->nullable();
            $table->decimal('ipr', 5, 2)->nullable();
            $table->decimal('total_score_comp', 5, 2)->nullable();
            $table->decimal('na', 5, 2)->nullable();
            $table->string('rating', 25)->nullable();
            $table->datetime('created_on')->nullable();
            $table->string('created_by', 25)->nullable();
            $table->datetime('modified_on')->nullable();
            $table->string('modified_by', 25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simulations');
    }
}
