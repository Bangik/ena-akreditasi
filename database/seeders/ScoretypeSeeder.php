<?php

namespace Database\Seeders;

use App\Models\Scoretype;
use Illuminate\Database\Seeder;

class ScoretypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Scoretype::create([
            'id' => 'pasma.a',
            'name' => 'Butir Kerja Inti',
            'weight' => '0.15',
            'isactive' => '1',
            'created_on' => '2020-04-21 00:04:54',
            'created_by' => '0',
            'modified_on' => '2020-04-21 00:04:54',
            'modified_by' => '0',
        ]);

        Scoretype::create([
            'id' => 'pasma.b',
            'name' => 'Butir Pemenuhan Relatif',
            'weight' => '0.85',
            'isactive' => '1',
            'created_on' => '2020-04-21 00:04:54',
            'created_by' => '0',
            'modified_on' => '2020-04-21 00:04:54',
            'modified_by' => '0',
        ]);
    }
}
