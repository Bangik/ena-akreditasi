<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $seed1 = ScoretypeSeeder::class;
        // $this->call($seed1);

        // $seed2 = ScoretypeComponentsSeeder::class;
        // $this->call($seed2);

        $seed3 = SimulationSeeder::class;
        $this->call($seed3);

        $seed4 = SimulationScoreSeeder::class;
        $this->call($seed4);

        $seed5 = SimulationScoreDetailSeeder::class;
        $this->call($seed5);

        $seed6 = SimulationDocumentSeeder::class;
        $this->call($seed6);

        $seed7 = SimulationDocDetailSeeder::class;
        $this->call($seed7);
    }
}
