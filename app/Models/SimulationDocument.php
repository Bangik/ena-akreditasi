<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationDocument extends Model
{
    use HasFactory;
    protected $table = 'simulation_documents';
    protected $fillable = ['id','parent_id', 'scoretype_component_id', 'score', 'score_max', 'created_on', 'modified_on'];
    public $timestamps = false;
    public $keyType = 'string';
    public $incrementing = false;

    public function simulationParent()
    {
        return $this->belongsTo(Simulation::class, 'parent_id', 'id');
    }

    public function scoretypeComponent()
    {
        return $this->belongsTo(ScoretypeComponents::class, 'scoretype_component_id', 'id');
    }

    public function simulationDocIndic()
    {
        return $this->hasMany(SimulationDocIndic::class, 'parent_id', 'id');
    }
}
