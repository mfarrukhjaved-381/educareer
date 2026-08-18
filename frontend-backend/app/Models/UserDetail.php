<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'userdetails'; 
    protected $fillable = [
        'user_id', 'full_name', 'email', 'phone', 'location', 'headline',
        'skills', 'education', 'experience', 'interests', 'languages',
        'certifications', 'projects', 'objective', 'resume_url', 'linkedin_url', 'data'
    ];
    
    

    protected $casts = [
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
