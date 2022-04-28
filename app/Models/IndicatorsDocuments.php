<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicatorsDocuments extends Model
{
    use HasFactory;
    protected $table = 'indicators_documents';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'parent_id', 'seq', 'name', 'isactive', 'created_on', 'created_by', 'modified_on', 'modified_by'];
    public $timestamps = false;
    public $keyType = 'string';

    public function indicatorsQuestions()
    {
        return $this->belongsTo(QuestionsIndicators::class, 'parent_id', 'id');
    }

    public function simulationDocDetail()
    {
        return $this->hasMany(SimulationDocDetail::class, 'indicators_documents_id', 'id');
    }
}
