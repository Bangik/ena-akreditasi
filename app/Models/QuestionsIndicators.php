<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsIndicators extends Model
{
    use HasFactory;
    protected $table = 'questions_indicators';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'parent_id',
        'seq',
        'name',
        'isactive',
        'created_on',
        'created_by',
        'modified_on',
        'modified_by',
    ];
    public $timestamps = false;
    public $keyType = 'string';

    public function questionsAnswers()
    {
        return $this->belongsTo(QuestionsAnswers::class, 'parent_id', 'id');
    }

    public function indicatorsDocuments()
    {
        return $this->hasMany(IndicatorsDocuments::class, 'parent_id', 'id');
    }

    public function simulationDocuments()
    {
        return $this->hasMany(SimulationDocument::class, 'parent_id', 'id');
    }
}
