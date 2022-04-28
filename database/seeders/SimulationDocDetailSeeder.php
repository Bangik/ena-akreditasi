<?php

namespace Database\Seeders;

use App\Models\SimulationDocDetail;
use Illuminate\Database\Seeder;

class SimulationDocDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SimulationDocDetail::create([
            'id' => 'simdocdet.1.1',
            'parent_id' => 'simdoc.1',
            'indicators_documents_id' => 'pasma.a.1.q.1.i.1.d.1',
            'is_checked' => 1,
            'created_on' => '2020-04-22 03:04:07',
            'modified_on' => '2020-04-22 03:04:07',
        ]);

        SimulationDocDetail::create([
            'id' => 'simdocdet.1.2',
            'parent_id' => 'simdoc.1',
            'indicators_documents_id' => 'pasma.a.1.q.1.i.1.d.2',
            'is_checked' => 1,
            'created_on' => '2020-04-22 03:04:07',
            'modified_on' => '2020-04-22 03:04:07',
        ]);

        SimulationDocDetail::create([
            'id' => 'simdocdet.1.3',
            'parent_id' => 'simdoc.1',
            'indicators_documents_id' => 'pasma.a.1.q.1.i.1.d.3',
            'is_checked' => 1,
            'created_on' => '2020-04-22 03:04:07',
            'modified_on' => '2020-04-22 03:04:07',
        ]);

        SimulationDocDetail::create([
            'id' => 'simdocdet.1.4',
            'parent_id' => 'simdoc.2',
            'indicators_documents_id' => 'pasma.a.1.q.1.i.2.d.1',
            'is_checked' => 1,
            'created_on' => '2020-04-22 03:04:07',
            'modified_on' => '2020-04-22 03:04:07',
        ]);

        SimulationDocDetail::create([
            'id' => 'simdocdet.1.5',
            'parent_id' => 'simdoc.2',
            'indicators_documents_id' => 'pasma.a.1.q.1.i.2.d.2',
            'is_checked' => 1,
            'created_on' => '2020-04-22 03:04:07',
            'modified_on' => '2020-04-22 03:04:07',
        ]);
    }
}
