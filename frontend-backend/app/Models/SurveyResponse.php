<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/SurveyResponse.php
class SurveyResponse extends Model
{
    protected $fillable = ['user_id', 'rating', 'feedback', 'anonymous'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

