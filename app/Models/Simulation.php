<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    use HasFactory;
    protected $table = 'simulations';
    protected $fillable = ['id', 'total_score', 'total_score_max','score_doc','score_doc_max', 'created_on', 'created_by', 'modified_on', 'modified_by'];
    public $timestamps = false;
    public $keyType = 'string';
    public $incrementing = false;

    public function scores()
    {
        return $this->hasMany(SimulationScore::class, 'parent_id', 'id');
    }

    public function scoreDoc()
    {
        return $this->hasMany(SimulationDocument::class, 'parent_id', 'id');
    }
}
