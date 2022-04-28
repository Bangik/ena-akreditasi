<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentsQuestions extends Model
{
    use HasFactory;
    protected $table = 'components_questions';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'parent_id', 'seq', 'name', 'isactive', 'created_on', 'created_by', 'modified_on', 'modified_by'];
    public $keyType = 'string';
    public $timestamps = false;

    public function scoretypeComponents()
    {
        return $this->belongsTo(ScoretypeComponents::class, 'parent_id', 'id');
    }

    public function questionsAnswers()
    {
        return $this->hasMany(QuestionsAnswers::class, 'parent_id', 'id');
    }

    public function questionsIndicators()
    {
        return $this->hasMany(QuestionsIndicators::class, 'parent_id', 'id');
    }
}
