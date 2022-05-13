<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationDocIndic extends Model
{
    use HasFactory;
    protected $table = 'simulation_doc_indic';
    protected $fillable = [
        'id',
        'parent_id',
        'questions_indicator_id',
        'score',
        'score_max',
        'created_on',
        'modified_on',
    ];
    public $timestamps = false;
    public $keyType = 'string';
    public $incrementing = false;

    public function simulationDocument()
    {
        return $this->belongsTo(SimulationDocument::class, 'parent_id', 'id');
    }

    public function questionIndicator()
    {
        return $this->belongsTo(QuestionsIndicators::class, 'questions_indicator_id', 'id');
    }

    public function simulationDocDetail()
    {
        return $this->hasMany(SimulationDocDetail::class, 'parent_id', 'id');
    }
}
