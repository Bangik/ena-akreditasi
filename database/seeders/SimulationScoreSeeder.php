<?php

namespace Database\Seeders;

use App\Models\SimulationScore;
use Illuminate\Database\Seeder;

class SimulationScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SimulationScore::create([
            'id' => 'sim.1.1',
            'parent_id' => 'sim.1',
            'scoretype_component_id' => 'pasma.a.1',
            'score' => 11,
            'score_max' => 44,
            'created_on' => '2020-04-22 03:04:07',
            'modified_on' => '2020-04-22 03:04:07',
        ]);

        SimulationScore::create([
            'id' => 'sim.1.2',
            'parent_id' => 'sim.1',
            'scoretype_component_id' => 'pasma.a.2',
            'score' => 6,
            'score_max' => 28,
            'created_on' => '2020-04-22 03:04:07',
            'modified_on' => '2020-04-22 03:04:07',
        ]);
    }
}
