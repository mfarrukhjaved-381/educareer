<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\UserRecommendation;
use Illuminate\Http\JsonResponse;
use Exception;
use League\Csv\Reader;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Process;
use App\Models\UserProfile;
use App\Models\Course;
use Illuminate\Support\Str;


class UserDashboardController extends Controller
{
    public function user_dashboard()
    {
        $user = Auth::user();
        $userId = Auth::id();
        $profile = UserProfile::firstOrNew(['user_id' => $userId]);
        // Call your private profile completion method
        $completion = $this->calculateProfileCompletion($profile);
    
        // Get latest recommendation if exists
        $recommendation = UserRecommendation::where('user_id', $user->id)->latest()->first();
    
        // Initialize empty structure to avoid errors
        $cvResults = [
            'jobs' => [],
            'courses' => [],
            'career_paths' => []
        ];
    
        // If recommendation exists and has data
        if ($recommendation && $recommendation->cv_data) {
            $cvData = json_decode($recommendation->cv_data, true);
    
            // Accessing the nested structure based on what you provided
            $cvResults['jobs'] = $cvData['recommended_jobs'] ?? ($cvData['jobs'] ?? []);
            $cvResults['courses'] = $cvData['courses']['courses'] ?? ($cvData['recommended_courses'] ?? []);
            $cvResults['career_paths'] = $cvData['recommended_career_paths']['paths'] ?? ($cvData['career_paths'] ?? []);
        }
    
        // Pass both $cvResults and $completion to the view
        return view('user-dashboard.dashboard', compact('cvResults', 'completion'));
    }
    

    public function showResumeForm()
    {
        return view('user-dashboard.cv');
    }
    public function cv(Request $request)
    {
        if ($request->isMethod('post')) {
            $fileType = '';
            $validationRules = [];
    
            if ($request->hasFile('cv_resume')) {
                $file = $request->file('cv_resume');
                $fileType = 'resume';
                $validationRules = ['cv_resume' => 'required|mimes:pdf,doc,docx,txt|max:2048'];
            }
    
            $request->validate($validationRules);
    
            if (!$file) {
                return back()->with('error', 'No file was uploaded.');
            }
    
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = storage_path('app/public/uploads/');
            $fullPath = $path . '/' . $filename;
    
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
    
            $file->move($path, $filename);
    
            try {
                // Send file to Python API
                $response = Http::timeout(100)
                    ->attach('cv', file_get_contents($fullPath), $filename)
                    ->post('http://localhost:5000/api/analyze-cv');
    
                if ($response->successful()) {
                    $data = $response->json();
    
                    Log::info('✅ Response from Python API:', $data);
    
                    $user = Auth::user();
    
                    // Save analysis result in DB
                    UserRecommendation::updateOrCreate(
                        ['user_id' => $user->id],
                        ['cv_data' => json_encode($data)]
                    );
    
                    // Mark CV as uploaded
                    $user->cv_uploaded = true;
                    $user->save();
    
                    // Refresh auth session.  Essential after modifying user data.
                    Auth::setUser($user->fresh());
    
                    return redirect()->route('dashboard')->with('success', 'CV uploaded successfully! Explore your personalized recommendations.');
                } else {
                    Log::error('❌ Python API error: ' . $response->body());
                    return back()->with('error', 'Failed to analyze CV. Please try again.');
                }
            } catch (\Exception $e) {
                Log::error('⚠️ CV Upload Exception: ' . $e->getMessage());
                return back()->with('error', 'An unexpected error occurred while uploading the CV.');
            }
        }
    
        // GET request: show CV upload page
        return view('user-dashboard.cv');
    }
    
    public function fetchRecommendations(): JsonResponse
    {
        $user = Auth::user();
        $recommendation = UserRecommendation::where('user_id', $user->id)->latest()->first();
        $cvResults = [
            'jobs' => [],
            'courses' => [],
            'career_paths' => [],
        ];
    
        if ($recommendation && $recommendation->cv_data) {
            $cvData = json_decode($recommendation->cv_data, true);
            $cvResults['jobs'] = $cvData['recommended_jobs'] ?? [];
            $cvResults['courses'] = $cvData['recommended_courses']['courses'] ?? [];
            $cvResults['career_paths'] = $cvData['recommended_career_paths']['paths'] ?? [];
        }
    
        return response()->json($cvResults);
    }
    public function recommended_jobs()
    {
        $user = Auth::user();
        $recommendation = UserRecommendation::where('user_id', $user->id)->first();
    
        if (!$recommendation) {
            return view('user-dashboard.recommended-jobs')->with('error', 'No recommendations found. Please upload your CV.');
        }
    
        $cvResults = json_decode($recommendation->cv_data, true);
    
        if (!$cvResults || !isset($cvResults['jobs'])) {
            return view('user-dashboard.recommended-jobs')->with('error', 'No job recommendations available. Please upload your CV.');
        }
    
        $recommendedJobs = $cvResults['jobs'];
    
        return view('user-dashboard.recommended-jobs', compact('recommendedJobs'));
    }

    public function recommended_courses()
    {
        $user = Auth::user();
        $recommendation = UserRecommendation::where('user_id', $user->id)->first();
    
        if (!$recommendation) {
            return view('user-dashboard.recommended-courses')->with('error', 'No recommendations found. Please upload your CV.');
        }
    
        $cvResults = json_decode($recommendation->cv_data, true);
    
        if (!$cvResults || !isset($cvResults['courses'])) {
            return view('user-dashboard.recommended-courses')->with('error', 'No course recommendations available. Please upload your CV.');
        }
        
        $matchedCourses = $cvResults['courses']['courses'];  // Access the nested array
       
    
        if (empty($matchedCourses)) {
            $error = "No courses matched the skills in your CV.";
            return view('user-dashboard.recommended-courses', compact('matchedCourses', 'error'));
        }
        
        return view('user-dashboard.recommended-courses', compact('matchedCourses'));
    }

    public function career_paths()
    {
        $user = Auth::user();
        $recommendation = UserRecommendation::where('user_id', $user->id)->first();

        if (!$recommendation) {
            return view('user-dashboard.career-paths')->with('error', 'No recommendations found. Please upload your CV.');
        }

        $cvResults = json_decode($recommendation->cv_data, true);

        if (!$cvResults || !isset($cvResults['career_paths'])) {
            return view('user-dashboard.career-paths')->with('error', 'No career path suggestions available. Please upload your CV.');
        }

        $careerPaths = $cvResults['career_paths'];


        return view('user-dashboard.career-paths', compact('careerPaths'));
    }

    public function smart_Resume()
    {
        $user = Auth::user();
        $recommendation = UserRecommendation::where('user_id', $user->id)->first();
    
        if (!$recommendation) {
            return view('user-dashboard.smart-resume')->with('error', 'Please upload your CV first.');
        }
    
        $cvResults = json_decode($recommendation->cv_data, true);
    
        $name = $cvResults['name'] ?? 'Unknown';
        $email = $cvResults['email'] ?? 'Not found';
        $education = $cvResults['education'] ?? [];
        $experience = $cvResults['experience'] ?? [];
        $skills = $cvResults['skills'] ?? [];
    
        // Simple scoring logic
        $score = 50;
        if (count($education) > 0) $score += 10;
        if (count($experience) > 0) $score += 20;
        if (count($skills) > 5) $score += 20;
    
        // Tips generation
        $tips = [];
        if (count($skills) < 5) $tips[] = 'Add more technical and soft skills.';
        if (count($education) == 0) $tips[] = 'Include your academic background.';
        if (count($experience) == 0) $tips[] = 'Mention internships or projects as experience.';
        if ($score < 80) $tips[] = 'Use industry keywords to pass ATS (e.g., "REST APIs", "machine learning").';
    
        return view('user-dashboard.smart-resume', compact(
            'name', 'email', 'education', 'experience', 'skills', 'score', 'tips'
        ));
    }
    
    public function smartResumeBuilder()
    {
        $user = Auth::user();
        $recommendation = UserRecommendation::where('user_id', $user->id)->first();
    
        if (!$recommendation) {
            return view('user-dashboard.smart-resume-builder')->with('error', 'Please upload your CV first.');
        }
    
        $cvResults = json_decode($recommendation->cv_data, true);
    
        $name = $cvResults['name'] ?? '';
        $email = $cvResults['email'] ?? '';
        $education = $cvResults['education'] ?? [];
        $experience = $cvResults['experience'] ?? [];
        $skills = $cvResults['skills'] ?? [];
    
        return view('user-dashboard.smart-resume-builder', compact(
            'name', 'email', 'education', 'experience', 'skills'
        ));
    }
    
    public function mentorship()
    {
        return view('user-dashboard.mentorship');
    }

    public function getRecommendedBooks()
    {
        // Dummy user skills (in real case, get from CV analysis or session)
        $userSkills = ['python', 'machine learning', 'data engineering'];
    
        // Load CSV from storage/app/public/
        $path = storage_path('app/data/recommended_books.csv');
        if (!file_exists($path)) {
            abort(404, 'Book dataset not found');
        }
    
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);
    
        $books = [];
        foreach ($csv->getRecords() as $record) {
            $bookSkills = explode(',', strtolower($record['Skills Covered']));
            $match = count(array_intersect(array_map('trim', $bookSkills), $userSkills));
            if ($match > 0) {
                $books[] = [
                    'title' => $record['Title'],
                    'author' => $record['Author'],
                    'skills' => $record['Skills Covered'],
                    'industry' => $record['Industry'],
                    'level' => $record['Level'],
                    'description' => $record['Description'],
                ];
            }
        }
    
        return view('user-dashboard.recommended-books', ['books' => $books]);
    }

    public function upskill(Request $request)
    {
        $user = Auth::user();
        $recommendation = UserRecommendation::where('user_id', $user->id)->first();
    
        if (!$recommendation) {
            return view('user-dashboard.upskill')->with('error', 'Please upload your CV to receive upskill suggestions.');
        }
    
        $cvResults = json_decode($recommendation->cv_data, true);
        $userSkills = $cvResults['skills'] ?? [];
    
        // 🔥 Load predefined core skills
        $coreSkills = json_decode(file_get_contents(storage_path('app/data/core_skills.json')), true);
    
        // 🧹 Normalize & filter user skills
        $filteredUserSkills = collect($userSkills)
            ->map(fn($skill) => strtolower(trim($skill)))
            ->filter(fn($skill) => in_array($skill, $coreSkills))
            ->unique()
            ->values()
            ->toArray();
    
        $careerPaths = json_decode(file_get_contents(storage_path('app/data/career_paths.json')), true);
    
        $selectedRole = $request->get('career_goal');
        $targetSkills = [];
        $missingSkills = [];
    
        if ($selectedRole) {
            foreach ($careerPaths as $path) {
                if (strtolower($path['role']) === strtolower($selectedRole)) {
                    $targetSkills = $path['skills'];
                    break;
                }
            }
    
            // 🧹 Normalize & filter target/missing skills
            $filteredTargetSkills = collect($targetSkills)
                ->map(fn($skill) => strtolower(trim($skill)))
                ->filter(fn($skill) => in_array($skill, $coreSkills))
                ->unique()
                ->values()
                ->toArray();
    
            $missingSkills = array_values(array_diff($filteredTargetSkills, $filteredUserSkills));
        }
    
        return view('user-dashboard.upskill', [
            'userSkills' => $filteredUserSkills,
            'careerPaths' => $careerPaths,
            'selectedRole' => $selectedRole,
            'targetSkills' => $targetSkills,
            'missingSkills' => $missingSkills,
        ]);
    }
    

    public function surveys()
    {
        return view('user-dashboard.surveys');
    }
    
    public function submitSurvey(Request $request)
    {
        $validated = $request->validate([
            'feedback' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        
        // Store feedback in the database or send it to a service
        Survey::create([
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'feedback' => $validated['feedback'],
        ]);
    
        return redirect()->route('surveys')->with('success', 'Thank you for your feedback!');
    }

    public function upgrade()
    {
        return view('user-dashboard.upgrade');
    }



    public function settings()
{
    return view('user-dashboard.settings');
}

public function updateSettings(Request $request)
{
    $user = Auth::user();

    // Validate only present fields (no 'required' for checkbox)
    $validated = $request->validate([
        'theme' => 'required|string|in:light,dark',
        'name' => 'nullable|string|max:255',
    ]);

    // Checkbox manually handled
    $user->theme = $validated['theme'];
    // $user->email_notifications = $request->has('email_notifications') ? 1 : 0;

    if ($request->filled('name')) {
        $user->name = $validated['name'];
    }

    $user->save();

    return redirect()->route('settings')->with('success', 'Settings updated successfully!');
}


public function showUploadData()
{
    return view('user-dashboard.upload-data');
}


public function uploadUserData(Request $request)
{
    $request->validate([
        'full_name' => 'required|string',
        'headline' => 'required|string',
        'location' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string',
        'skills' => 'required|array',
        'skills.*' => 'required|string',
        'education' => 'required|array',
        'education.degree.*' => 'required|string',
        'education.institute.*' => 'required|string',
        'education.duration.*' => 'required|string',
        'experience' => 'nullable|array',
        'experience.title.*' => 'nullable|string',
        'experience.company.*' => 'nullable|string',
        'experience.duration.*' => 'nullable|string',
        'interests' => 'nullable|array',
        'interests.*' => 'nullable|string',
         'languages' => 'nullable|array',
        'languages.*' => 'nullable|string',
        'certifications' => 'nullable|array',
        'certifications.*' => 'nullable|string',
        'projects' => 'nullable|array',
        'projects.title.*' => 'nullable|string',
        'projects.description.*' => 'nullable|string',
        'objective' => 'required|string',
    ]);

    // Combine all form data
    $allData = [
        'full_name' => $request->input('full_name'),
        'headline' => $request->input('headline'),
        'location' => $request->input('location'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'skills' => $request->input('skills'),
        'education' => $request->input('education'),
        'experience' => $request->input('experience', []),
        'interests' => $request->input('interests', []),
        'languages' => $request->input('languages', []),
        'certifications' => $request->input('certifications', []),
        'projects' => $request->input('projects', []),
        'objective' => $request->input('objective'),
        'linkedin_url' => $request->input('linkedin_url'),
    ];

    // 1. Save all form data to the database
    UserDetail::updateOrCreate(
        ['user_id' => Auth::id()],
        [
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'location' => $request->input('location'),
            'headline' => $request->input('headline'),
            'skills' => json_encode($request->input('skills')),
            'education' => json_encode($request->input('education')),
            'experience' => json_encode($request->input('experience', [])),
            'interests' => json_encode($request->input('interests', [])),
            'languages' => json_encode($request->input('languages', [])),
            'certifications' => json_encode($request->input('certifications', [])),
            'projects' => json_encode($request->input('projects', [])),
            'objective' => $request->input('objective'),
            'resume_url' => $request->input('resume_url'),
            'linkedin_url' => $request->input('linkedin_url.link.0'), // First link
            'data' => json_encode($allData), // full raw form backup
        ]
    );
    

    // 2. Extract skills (from the 'skills' array) for Python API
      $skills = $request->input('skills');
      Log::info('Extracted Skills from Form:', $skills);

    try {
        // 3. Send data to Python API for analysis
        $response = Http::post('http://localhost:5000/api/analyze-data', [
            'data' => $allData, // Send all the form data
            'skills' => $skills,
        ]);

        if ($response->successful()) {
            $analysisResult = $response->json();
            Log::info('✅ Response from Python API:', $analysisResult);

            // Save analysis result
            UserRecommendation::updateOrCreate(
                ['user_id' => Auth::id()],
                ['cv_data' => json_encode($analysisResult)]
            );
            $user = Auth::user();
             $user->cv_uploaded = true; // Reuse the cv_uploaded field.
             $user->save();
             Auth::setUser($user->fresh());

            // 4. Redirect with success message
            return redirect()->route('dashboard')->with('success', 'Your data has been processed successfully!');
        } else {
            Log::error('❌ Python API error: ' . $response->body());
            return back()->with('error', 'Failed to analyze your data. Please try again.');
        }
    } catch (\Exception $e) {
        Log::error('⚠️ Error sending data to Python API: ' . $e->getMessage());
        return back()->with('error', 'An unexpected error occurred. Please try again.');
    }
}


public function profile()
{
     $user = Auth::user();
     $userProfile = \App\Models\UserProfile::firstOrCreate(
        ['user_id' => $user->id],
        ['name' => $user->name, 'email' => $user->email] // default values
    );
    $completion = $this->calculateProfileCompletion($userProfile);
    return view('user-dashboard.profile', compact('userProfile', 'completion'));
}



public function updateProfile(Request $request)
{
    $userId = Auth::id();

    $request->validate([
        'skills' => 'nullable|string',
        'education' => 'required|string',
        'experience' => 'nullable|string',
        'projects' => 'nullable|string',
        'certifications' => 'nullable|string',
        'interests' => 'nullable|string',
    ]);

    $profile = UserProfile::where('user_id', $userId)->first();

    if (!$profile) {
        $profile = new UserProfile();
        $profile->user_id = $userId;
    }

    $profile->name = $request->input('name');
    $profile->email = $request->input('email');
    $profile->role = $request->input('role');
    $profile->location = $request->input('location');
    $profile->summary = $request->input('summary');
    $profile->skills = json_encode(explode(',', $request->input('skills')));
    $profile->education = json_encode([$request->input('education')]); // Ensure valid JSON
    $profile->experience = json_encode([$request->input('experience')]);
    $profile->projects = json_encode([$request->input('projects')]);
    $profile->certifications = json_encode([$request->input('certifications')]);
    $profile->interests = json_encode(explode(',', $request->input('interests')));
    $profile->save();
    

    return back()->with('success', 'Profile updated successfully!');
}


private function calculateProfileCompletion($user)
{
    $fields = [
        'name', 'email', 'role', 'location', 'summary',
        'education', 'skills', 'experience' , 'interests' , 'projects' , 'certifications'
    ];

    $filled = 0;

    foreach ($fields as $field) {
        if (!empty($user->$field)) $filled++;
    }

    return intval(($filled / count($fields)) * 100);
}

public function courses()
{
    $courses = Course::latest()->get(); // You can customize ordering if needed
    return view('user-dashboard.courses', compact('courses'));
}

public function skillGapReport(Request $request)
{
    $user = Auth::user();
    $recommendation = UserRecommendation::where('user_id', $user->id)->first();
    if (!$recommendation) {
        return redirect()->route('upskill')->with('error', 'Upload your CV to access the skill gap report.');
    }

    $cvResults = json_decode($recommendation->cv_data, true);
    $userSkills = $cvResults['skills'] ?? [];

    $careerPaths = json_decode(file_get_contents(storage_path('app/data/career_paths.json')), true);
    $selectedRole = $request->get('role');
    $targetSkills = [];
    $missingSkills = [];

    foreach ($careerPaths as $path) {
        if (strtolower($path['role']) === strtolower($selectedRole)) {
            $targetSkills = $path['skills'];
            break;
        }
    }

    foreach ($targetSkills as $skill) {
        if (!in_array(strtolower($skill), array_map('strtolower', $userSkills))) {
            $missingSkills[] = $skill;
        }
    }

    return view('user-dashboard.skill-gap-report', compact('selectedRole', 'userSkills', 'targetSkills', 'missingSkills'));
}

}