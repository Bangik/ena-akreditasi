<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationDocument extends Model
{
    use HasFactory;
    protected $table = 'simulation_documents';
    protected $fillable = ['id','parent_id', 'questions_indicator_id', 'score', 'score_max', 'created_on', 'modified_on'];
    public $timestamps = false;
    public $keyType = 'string';
    public $incrementing = false;

    public function simulationParent()
    {
        return $this->belongsTo(Simulation::class, 'parent_id', 'id');
    }

    public function questionsIndicator()
    {
        return $this->belongsTo(QuestionsIndicators::class, 'questions_indicator_id', 'id');
    }

    public function simulationDocDetail()
    {
        return $this->hasMany(SimulationDocDetail::class, 'parent_id', 'id');
    }
}
