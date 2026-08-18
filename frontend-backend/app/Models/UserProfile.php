<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $casts = [
        'skills' => 'array',
        'interests' => 'array',
        'education' => 'string',
        'experience' => 'string',
        'projects' => 'string',
        'certifications' => 'string',
    ];
    protected $fillable = [
        'user_id', 'name', 'email', 'role', 'location', 'summary',
        'skills', 'education', 'experience', 'projects', 'certifications', 'interests'
    ];
    
    
}
