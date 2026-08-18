<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    // Display a listing of the courses
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('admin.pages.dashboard-pages.courses', compact('courses'));
    }

    // Show form to create a new course
    public function create()
    {
        return view('admin.pages.dashboard-pages.create-courses');
    }

    // Store a new course in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructor' => 'nullable|string|max:255',
            'url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);
    
        Course::create($request->only([
            'title',
            'instructor',
            'url',
            'description',
        ]));
    
        return redirect()->route('admin.courses')
                         ->with('success', 'Course created successfully.');
    }
    

    // Show form to edit a course
    public function edit(Course $course)
    {
        return view('admin.pages.dashboard-pages.edit-courses', compact('course'));
    }

    // Update a course
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructor' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
        ]);

        $course->update($request->all());

        return redirect()->route('admin.courses')->with('success', 'Course updated successfully.');
    }

    // Delete a course
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses')->with('success', 'Course deleted successfully.');
    }
}

