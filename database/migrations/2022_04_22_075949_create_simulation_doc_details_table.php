<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimulationDocDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulation_doc_details', function (Blueprint $table) {
            $table->string('id', 25)->primary();
            $table->string('parent_id', 25);
            $table->foreign('parent_id')->references('id')->on('simulation_documents')->onUpdate('cascade')->onDelete('cascade');
            $table->string('indicators_documents_id', 25);
            $table->foreign('indicators_documents_id')->references('id')->on('indicators_documents')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('is_checked', false, false)->nullable();
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
        Schema::dropIfExists('simulation_doc_details');
    }
}
