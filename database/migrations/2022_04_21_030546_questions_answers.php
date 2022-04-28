<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuestionsAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_answers', function (Blueprint $table) {
            $table->string('id', 25)->primary();
            $table->string('parent_id', 25);
            $table->foreign('parent_id')->references('id')->on('components_questions')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('level', false, false);
            $table->text('name');
            $table->string('isactive', 1)->default('1');
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
        //
    }
}
