<?php

namespace Database\Seeders;

use App\Models\ComponentsQuestions;
use Illuminate\Database\Seeder;

class ComponentsQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ComponentsQuestions::create([
            'id' => 'pasma.a.1.q.1',
            'parent_id' => 'pasma.a.1',
            'seq' => '1',
            'name' => 'Siswa menunjukkan perilaku disiplin dalam berbagai situasi.',
            'isactive' => '1',
            'created_on' => '2020-04-21 00:04:54',
            'created_by' => '0',
            'modified_on' => '2020-04-21 00:04:54',
            'modified_by' => '0',
        ]);

        ComponentsQuestions::create([
            'id' => 'pasma.a.1.q.2',
            'parent_id' => 'pasma.a.1',
            'seq' => '2',
            'name' => 'Siswa menunjukkan perilaku religius dalam aktivitas di sekolah/ madrasah.',
            'isactive' => '1',
            'created_on' => '2020-04-21 00:04:54',
            'created_by' => '0',
            'modified_on' => '2020-04-21 00:04:54',
            'modified_by' => '0',
        ]);

        ComponentsQuestions::create([
            'id' => 'pasma.a.1.q.3',
            'parent_id' => 'pasma.a.1',
            'seq' => '3',
            'name' => ' Siswa menunjukkan perilaku tangguh dan bertanggung jawab dalam aktivitas di sekolah/madrasah.',
            'isactive' => '1',
            'created_on' => '2020-04-21 00:04:54',
            'created_by' => '0',
            'modified_on' => '2020-04-21 00:04:54',
            'modified_by' => '0',
        ]);

        ComponentsQuestions::create([
            'id' => 'pasma.a.1.q.4',
            'parent_id' => 'pasma.a.1',
            'seq' => '4',
            'name' => 'Siswa terbebas dari perundungan (bully) di sekolah/madrasah.',
            'isactive' => '1',
            'created_on' => '2020-04-21 00:04:54',
            'created_by' => '0',
            'modified_on' => '2020-04-21 00:04:54',
            'modified_by' => '0',
        ]);
    }
}
