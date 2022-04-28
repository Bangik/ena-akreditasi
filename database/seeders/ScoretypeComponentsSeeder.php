<?php

namespace Database\Seeders;

use App\Models\ScoretypeComponents;
use Illuminate\Database\Seeder;

class ScoretypeComponentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScoretypeComponents::create([
            'id' => 'pasma.a.1',
            'parent_id' => 'pasma.a',
            'name' => 'Mutu Lulusan',
            'isactive' => '1',
            'created_on' => '2020-04-21 00:04:54',
            'created_by' => '0',
            'modified_on' => '2020-04-21 00:04:54',
            'modified_by' => '0',
        ]);

        ScoretypeComponents::create([
            'id' => 'pasma.a.2',
            'parent_id' => 'pasma.a',
            'name' => 'Proses Pembelajaran',
            'isactive' => '1',
            'created_on' => '2020-04-21 00:04:54',
            'created_by' => '0',
            'modified_on' => '2020-04-21 00:04:54',
            'modified_by' => '0',
        ]);

        ScoretypeComponents::create([
            'id' => 'pasma.a.3',
            'parent_id' => 'pasma.a',
            'name' => 'Mutu Guru',
            'isactive' => '1',
            'created_on' => '2020-04-21 00:04:54',
            'created_by' => '0',
            'modified_on' => '2020-04-21 00:04:54',
            'modified_by' => '0',
        ]);

        ScoretypeComponents::create([
            'id' => 'pasma.a.4',
            'parent_id' => 'pasma.a',
            'name' => 'Manajemen Sekolah',
            'isactive' => '1',
            'created_on' => '2020-04-21 00:04:54',
            'created_by' => '0',
            'modified_on' => '2020-04-21 00:04:54',
            'modified_by' => '0',
        ]);

        ScoretypeComponents::create([
            'id' => 'pasma.b.1',
            'parent_id' => 'pasma.b',
            'name' => 'Indikator Pemenuhan Relatif (IPR)',
            'isactive' => '1',
            'created_on' => '2020-04-21 00:04:54',
            'created_by' => '0',
            'modified_on' => '2020-04-21 00:04:54',
            'modified_by' => '0',
        ]);
    }
}
