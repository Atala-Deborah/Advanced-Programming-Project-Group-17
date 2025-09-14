<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectParticipant extends Model
{
    use HasFactory;

    protected $table = 'project_participants';
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'ProjectId',
        'ParticipantId',
        'RoleOnProject',
        'SkillRole'
    ];

    protected $casts = [
        'RoleOnProject' => 'string',
        'SkillRole' => 'string',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectId', 'ProjectId');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'ParticipantId', 'ParticipantId');
    }
}
