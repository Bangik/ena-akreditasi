<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsAnswers extends Model
{
    use HasFactory;
    protected $table = 'questions_answers';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'parent_id', 'level', 'name', 'isactive', 'created_on', 'created_by', 'modified_on', 'modified_by'];
    public $keyType = 'string';
    public $timestamps = false;

    public function componentQuestions()
    {
        return $this->belongsTo(ComponentsQuestions::class, 'parent_id', 'id');
    }
}
