<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationScore extends Model
{
    use HasFactory;
    protected $table = 'simulations_score';
    protected $fillable = ['id', 'parent_id', 'scoretype_component_id', 'score', 'score_max', 'score_doc', 'score_doc_max', 'score_comp','created_on', 'modified_on'];
    public $timestamps = false;
    public $keyType = 'string';
    public $incrementing = false;

    public function scoretype_component()
    {
        return $this->belongsTo(ScoretypeComponents::class, 'scoretype_component_id', 'id');
    }

    public function simulation()
    {
        return $this->belongsTo(Simulation::class, 'parent_id', 'id');
    }

    public function simulationDetails()
    {
        return $this->hasMany(SimulationScoreDetail::class, 'parent_id', 'id');
    }

    public function simulationDocIndic()
    {
        return $this->hasMany(SimulationDocIndic::class, 'parent_id', 'id');
    }
}
