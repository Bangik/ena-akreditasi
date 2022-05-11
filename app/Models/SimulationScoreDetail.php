<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationScoreDetail extends Model
{
    use HasFactory;
    protected $table = 'simulation_score_details';
    protected $fillable = ['id', 'parent_id', 'component_questions_id', 'score', 'created_on', 'modified_on'];
    public $timestamps = false;
    public $keyType = 'string';
    public $incrementing = false;

    public function component_questions()
    {
        return $this->belongsTo(ComponentsQuestions::class, 'component_questions_id', 'id');
    }

    public function simulation_score()
    {
        return $this->belongsTo(SimulationScore::class, 'parent_id', 'id');
    }
}
