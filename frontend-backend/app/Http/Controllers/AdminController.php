<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Course;
use App\Models\CareerPath;
class AdminController extends Controller

{
    public function index()
    {
        // Total number of users
        $totalUsers = User::count();
    
    
        // Latest 20 users with relevant fields
        $users = User::select('id', 'name', 'email', 'cv_uploaded', 'subscription_status', 'created_at')
                    ->latest()
                    ->take(20)
                    ->get();
    
        // Total number of courses
        $totalCourses = Course::count();
    
    
        return view('admin.pages.dashboard-pages.dashboard', [
            'totalUsers' => $totalUsers,
            'users' => $users,
            'totalCourses' => $totalCourses,
        ]);
    }
    
    public function users()
    {
        $users = User::all();
        return view('admin.pages.dashboard-pages.users', compact('users'));
    }
    public function courses()
    {
        $courses = Course::orderBy('id', 'desc')->paginate(10); // Add paginate()
        return view('admin.pages.dashboard-pages.courses', compact('courses'));
    }
    
    public function careerPaths()
    {
        $careerPaths = CareerPath::latest()->get();
        return view('admin.pages.dashboard-pages.careerPaths', compact('careerPaths'));
    }
    public function settings()
    {
        return view('admin.pages.dashboard-pages.settings');
    }
    public function userProgress()
    {
        return view('admin.pages.dashboard-pages.userProgress');
    }
    public function profile()
    {
        $user = auth()->user(); // Get currently logged-in user
        return view('admin.pages.dashboard-pages.profile', compact('user'));
    }
    
    // Show create form
public function createUser()
{
    return view('admin.pages.dashboard-pages.create-user');
}

// Store new user
public function storeUser(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('admin.users')->with('success', 'User created successfully.');
}

// Show edit form
public function editUser($id)
{
    $user = User::findOrFail($id);
    return view('admin.pages.dashboard-pages.edit-user', compact('user'));
}

// Update user
public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    if ($request->password) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('admin.users')->with('success', 'User updated successfully.');
}

// Delete user
public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
}
public function createCourse()
{
    return view('admin.pages.dashboard-pages.create-courses'); // make sure this Blade view exists
}
// Show form
public function createCareerPath()
{
    return view('admin.pages.dashboard-pages.createCareerPath');
}

// Store new career path
public function storeCareerPath(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'skills' => 'nullable|string',
    ]);

    CareerPath::create($validated);

    return redirect()->route('admin.careerPaths')->with('success', 'Career Path added successfully!');
}
public function editCareerPath($id)
{
    $careerPath = CareerPath::findOrFail($id);
    return view('admin.pages.dashboard-pages.editCareerPath', compact('careerPath'));
}

public function updateCareerPath(Request $request, $id)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'skills' => 'nullable|string',
    ]);

    $careerPath = CareerPath::findOrFail($id);
    $careerPath->update($validated);

    return redirect()->route('admin.careerPaths')->with('success', 'Career Path updated successfully!');
}

public function deleteCareerPath($id)
{
    $careerPath = CareerPath::findOrFail($id);
    $careerPath->delete();

    return redirect()->route('admin.careerPaths')->with('success', 'Career Path deleted successfully!');
}

}
