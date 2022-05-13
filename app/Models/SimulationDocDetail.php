<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationDocDetail extends Model
{
    use HasFactory;
    protected $table = 'simulation_doc_details';
    protected $fillable = ['id','parent_id', 'indicators_documents_id', 'is_checked', 'created_on', 'modified_on'];
    public $timestamps = false;
    public $keyType = 'string';
    public $incrementing = false;

    public function simulationParent()
    {
        return $this->belongsTo(SimulationDocIndic::class, 'parent_id', 'id');
    }

    public function simulationIndicatorsDocument()
    {
        return $this->belongsTo(IndicatorsDocuments::class, 'indicators_documents_id', 'id');
    }
}
