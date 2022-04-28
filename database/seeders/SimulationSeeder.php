<?php

namespace Database\Seeders;

use App\Models\Simulation;
use Illuminate\Database\Seeder;

class SimulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Simulation::create([
            'id' => 'sim.1',
            'total_score' => 17,
            'total_score_max' => 140,
            'score_doc' => 17,
            'score_doc_max' => 140,
            'created_on' => '2020-04-22 03:04:07',
            'created_by' => '1',
            'modified_on' => '2020-04-22 03:04:07',
            'modified_by' => '1',
        ]);

        // Simulation::create([
        //     'id' => 'sim.2',
        //     'total_score' => 6,
        //     'total_score_max' => 140,
        //     'created_on' => '2020-04-22 03:04:07',
        //     'created_by' => '1',
        //     'modified_on' => '2020-04-22 03:04:07',
        //     'modified_by' => '1',
        // ]);
    }
}
