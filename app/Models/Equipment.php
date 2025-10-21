<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';
    protected $primaryKey = 'EquipmentId';

    protected $fillable = [
        'FacilityId', 'Name', 'Capabilities', 'Description', 'InventoryCode', 'UsageDomain', 'SupportPhase'
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'FacilityId');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_equipment', 'EquipmentId', 'ProjectId')
            ->withTimestamps();
    }
}
