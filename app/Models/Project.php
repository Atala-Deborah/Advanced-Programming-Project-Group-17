<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $primaryKey = 'ProjectId';
    
    protected $fillable = [
        'Title',
        'Description',
        'Status',
        'NatureOfProject',
        'InnovationFocus',
        'PrototypeStage',
        'StartDate',
        'EndDate',
        'FacilityId',
        'ProgramId',
        'TestingRequirements',
        'CommercializationPlan'
    ];

    protected $casts = [
        'StartDate' => 'date',
        'EndDate' => 'date'
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'FacilityId', 'FacilityId');
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'project_equipment', 'ProjectId', 'EquipmentId')
                    ->withTimestamps();
    }

    public function participants()
    {
        return $this->belongsToMany(
            Participant::class,
            'project_participants',
            'ProjectId',
            'ParticipantId'
        )->withPivot(['RoleOnProject', 'SkillRole']);
    }

    public function outcomes()
    {
        return $this->hasMany(Outcome::class, 'ProjectId', 'ProjectId');
    }
}
