<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    use HasFactory;

    protected $primaryKey = 'OutcomeId';

    protected $fillable = [
        'ProjectId',
        'Title',
        'Description',
        'ArtifactLink',
        'OutcomeType',
        'QualityCertification',
        'CommercializationStatus'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectId', 'ProjectId');
    }
}
