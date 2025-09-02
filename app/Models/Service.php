<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services'; // Table name
    protected $primaryKey = 'ServiceId'; // Primary key
    public $incrementing = true; // Auto-increment ID
    protected $keyType = 'int'; // ID type

    protected $fillable = [
        'FacilityId',
        'Name',
        'Description',
        'Category',
        'SkillType'
    ];

    // Relationship: A service belongs to a facility
    public function facility()
    {
        return $this->belongsTo(Facility::class, 'FacilityId');
    }
}
