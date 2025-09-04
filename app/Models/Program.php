<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $primaryKey = 'ProgramId';

    protected $fillable = [
        'Name',
        'Description',
        'NationalAlignment',
        'FocusAreas',
        'Phases'
    ];

    protected $casts = [
        'Phases' => 'string'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'ProgramId', 'ProgramId');
    }
}
