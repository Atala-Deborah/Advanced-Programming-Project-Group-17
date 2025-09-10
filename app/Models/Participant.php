<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $primaryKey = 'ParticipantId';

    protected $fillable = [
        'FullName',
        'Email',
        'Affiliation',
        'Specialization',
        'CrossSkillTrained',
        'Institution'
    ];

    protected $casts = [
        'CrossSkillTrained' => 'boolean'
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_participants', 'ParticipantId', 'ProjectId')
                    ->withPivot('RoleOnProject', 'SkillRole')
                    ->withTimestamps();
    }
}
