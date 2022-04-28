<?php

namespace Database\Seeders;

use App\Models\SimulationDocument;
use Illuminate\Database\Seeder;

class SimulationDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SimulationDocument::create([
            'id' => 'simdoc.1',
            'parent_id' => 'sim.1',
            'questions_indicator_id' => 'pasma.a.2.q.1.i.1',
            'score' => 3,
            'score_max' => 3,
            'created_on' => '2020-04-22 03:04:07',
            'modified_on' => '2020-04-22 03:04:07',
        ]);

        SimulationDocument::create([
            'id' => 'simdoc.2',
            'parent_id' => 'sim.1',
            'questions_indicator_id' => 'pasma.a.2.q.1.i.2',
            'score' => 2,
            'score_max' => 3,
            'created_on' => '2020-04-22 03:04:07',
            'modified_on' => '2020-04-22 03:04:07',
        ]);
    }
}
