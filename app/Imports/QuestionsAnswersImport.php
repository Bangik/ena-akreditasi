<?php

namespace App\Imports;

use App\Models\QuestionsAnswers;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class QuestionsAnswersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new QuestionsAnswers([
            'id' => $row[0],
            'parent_id' => $row[1],
            'level' => $row[2],
            'name' => $row[3],
            'isactive' => $row[4],
            'created_on' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_by' => $row[6],
            'modified_on' => Carbon::now()->format('Y-m-d H:i:s'),
            'modified_by' => $row[8],
        ]);
    }
}
