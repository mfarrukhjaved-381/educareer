<?php

namespace App\Http\Controllers;

// app/Http/Controllers/SurveyController.php
use Illuminate\Support\Facades\Auth;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string|max:1000',
            'anonymous' => 'nullable|boolean',
        ]);

        SurveyResponse::create([
            'user_id' => $request->has('anonymous') ? null : Auth::id(),
            'rating' => $validated['rating'],
            'feedback' => $validated['feedback'],
            'anonymous' => $request->has('anonymous'),
        ]);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
}

