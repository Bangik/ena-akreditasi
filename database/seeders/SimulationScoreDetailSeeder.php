<?php

namespace Database\Seeders;

use App\Models\SimulationScoreDetail;
use Illuminate\Database\Seeder;

class SimulationScoreDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SimulationScoreDetail::create([
            'id' => 'sim.detail.1',
            'parent_id' => 'sim.1.1',
            'component_questions_id' => 'pasma.a.1.q.1',
            'score' => 4,
        ]);

        SimulationScoreDetail::create([
            'id' => 'sim.detail.2',
            'parent_id' => 'sim.1.1',
            'component_questions_id' => 'pasma.a.1.q.2',
            'score' => 4,
        ]);

        SimulationScoreDetail::create([
            'id' => 'sim.detail.3',
            'parent_id' => 'sim.1.1',
            'component_questions_id' => 'pasma.a.1.q.3',
            'score' => 3,
        ]);

        SimulationScoreDetail::create([
            'id' => 'sim.detail.4',
            'parent_id' => 'sim.1.2',
            'component_questions_id' => 'pasma.a.2.q.1',
            'score' => 3,
        ]);

        SimulationScoreDetail::create([
            'id' => 'sim.detail.5',
            'parent_id' => 'sim.1.2',
            'component_questions_id' => 'pasma.a.2.q.2',
            'score' => 3,
        ]);
    }
}
