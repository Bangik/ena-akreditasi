<?php

use Database\Seeders\ScoretypeComponentsSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ScoretypeComponents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scoretype_components', function (Blueprint $table) {
            $table->string('id', 25)->primary();
            $table->string('parent_id', 25);
            $table->foreign('parent_id')->references('id')->on('scoretype')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 50);
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('isactive', 1)->default('1');
            $table->datetime('created_on')->nullable();
            $table->string('created_by', 25)->nullable();
            $table->datetime('modified_on')->nullable();
            $table->string('modified_by', 25)->nullable();
        });

        $seed = new ScoretypeComponentsSeeder();
        $seed->run();
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
