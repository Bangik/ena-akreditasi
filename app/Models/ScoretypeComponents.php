<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoretypeComponents extends Model
{
    use HasFactory;
    protected $table = 'scoretype_components';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'parent_id', 'name', 'isactive', 'created_on', 'created_by', 'modified_on', 'modified_by'];
    public $timestamps = false;
    public $keyType = 'string';

    public function scoretype()
    {
        return $this->belongsTo(Scoretype::class, 'parent_id', 'id');
    }

    public function componentQuestions()
    {
        return $this->hasMany(ComponentsQuestions::class, 'parent_id', 'id');
    }

    public function simulationScore()
    {
        return $this->hasMany(SimulationScore::class, 'scoretype_component_id', 'id');
    }

    public function simulationDocument()
    {
        return $this->hasMany(SimulationDocument::class, 'scoretype_component_id', 'id');
    }
}
