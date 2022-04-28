<?php

use Database\Seeders\ScoretypeSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Scoretype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scoretype', function (Blueprint $table) {
            $table->string('id', 25)->primary();
            $table->string('name');
            $table->decimal('weight', 2, 2);
            $table->string('isactive', 1)->default('1');
            $table->datetime('created_on')->nullable();
            $table->string('created_by', 25)->nullable();
            $table->datetime('modified_on')->nullable();
            $table->string('modified_by', 25)->nullable();
        });

        $seed = new ScoretypeSeeder();
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
