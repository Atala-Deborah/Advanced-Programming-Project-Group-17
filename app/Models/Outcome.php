<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected $appends = ['artifact_url'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectId', 'ProjectId');
    }

    /**
     * Get the URL for the artifact
     *
     * @return string|null
     */
    public function getArtifactUrlAttribute()
    {
        if (!$this->ArtifactLink) {
            return null;
        }

        // Check if the link is already a full URL
        if (filter_var($this->ArtifactLink, FILTER_VALIDATE_URL)) {
            return $this->ArtifactLink;
        }

        // Check if the file exists in storage
        if (Storage::disk('public')->exists($this->ArtifactLink)) {
            return Storage::disk('public')->url($this->ArtifactLink);
        }

        // If the file doesn't exist, return null
        return null;
    }
}
