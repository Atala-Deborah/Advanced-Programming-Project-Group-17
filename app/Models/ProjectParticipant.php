<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'role'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'ProjectId');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
