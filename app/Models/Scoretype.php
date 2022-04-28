<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scoretype extends Model
{
    use HasFactory;
    protected $table = 'scoretype';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'name', 'weight', 'isactive', 'created_on', 'created_by', 'modified_on', 'modified_by'];
    public $timestamps = false;
    public $keyType = 'string';
    
    public function scoretypeComponent()
    {
        return $this->hasMany(ScoretypeComponents::class, 'parent_id', 'id');
    }
}
