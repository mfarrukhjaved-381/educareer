<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\SurveyController;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Home Controller

Route::get('/',[HomeController::class, 'home_page']);
Route::get('/courses',[HomeController::class, 'courses']);
Route::get('/about-area',[HomeController::class, 'about_area']);
Route::get('/coursers-details',[HomeController::class, 'coursers_details']);
Route::get('/element',[HomeController::class, 'element']);
Route::get('/blog',[HomeController::class, 'blog']);
Route::get('/single-blog',[HomeController::class, 'single_blog']);
Route::get('/contact_page',[HomeController::class, 'contact_page']);

// Home Controller Ending



// Admin Controller
Route::get('admin/dashboard',[AdminController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.dashboard');
Route::get('admin/users',[AdminController::class, 'users'])->middleware(['auth', 'admin'])->name('admin.users');
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/courses', [CourseController::class, 'index'])->name('admin.courses');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses/store', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
});
Route::get('admin/careerPaths',[AdminController::class, 'careerPaths'])->middleware(['auth', 'admin'])->name('admin.careerPaths');
Route::get('admin/userProgress',[AdminController::class, 'userProgress'])->middleware(['auth', 'admin'])->name('admin.userProgress');
Route::get('admin/settings',[AdminController::class, 'settings'])->middleware(['auth', 'admin'])->name('admin.settings');
Route::get('admin/profile',[AdminController::class, 'profile'])->middleware(['auth', 'admin'])->name('admin.profile');

// Show form to create a new user
Route::get('admin/users/create', [AdminController::class, 'createUser'])->middleware(['auth', 'admin'])->name('admin.users.create');

// Store new user
Route::post('admin/users/store', [AdminController::class, 'storeUser'])->middleware(['auth', 'admin'])->name('admin.users.store');

// Edit user form
Route::get('admin/users/{id}/edit', [AdminController::class, 'editUser'])->middleware(['auth', 'admin'])->name('admin.users.edit');

// Update user
Route::put('admin/users/{id}/update', [AdminController::class, 'updateUser'])->middleware(['auth', 'admin'])->name('admin.users.update');

// Delete user
Route::delete('admin/users/{id}/delete', [AdminController::class, 'deleteUser'])->middleware(['auth', 'admin'])->name('admin.users.delete');

Route::get('admin/careerPaths/create', [AdminController::class, 'createCareerPath'])->middleware(['auth', 'admin'])->name('admin.careerPaths.create');
Route::post('admin/careerPaths/store', [AdminController::class, 'storeCareerPath'])->middleware(['auth', 'admin'])->name('admin.careerPaths.store');
Route::get('admin/careerPaths/{id}/edit', [AdminController::class, 'editCareerPath'])->middleware(['auth', 'admin'])->name('admin.careerPaths.edit');
Route::post('admin/careerPaths/{id}/update', [AdminController::class, 'updateCareerPath'])->middleware(['auth', 'admin'])->name('admin.careerPaths.update');
Route::delete('admin/careerPaths/{id}', [AdminController::class, 'deleteCareerPath'])->middleware(['auth', 'admin'])->name('admin.careerPaths.delete');


// Admin Controller Ending



// User Dashboard Controller

Route::get('/dashboard',[UserDashboardController::class, 'user_dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/upload_cv',[UserDashboardController::class, 'cv'])->middleware(['auth', 'verified'])->name('cv.upload');

Route::get('/resume', [UserDashboardController::class, 'showResumeForm'])->middleware(['auth', 'verified'])->name('cv');

Route::get('/recommended-jobs', [UserDashboardController::class, 'recommended_jobs'])->middleware(['auth', 'verified'])->name('recommended-jobs');

Route::get('/recommended-courses', [UserDashboardController::class, 'recommended_courses'])->middleware(['auth', 'verified'])->name('recommended-courses');

Route::get('/smart-resume',[UserDashboardController::class, 'smart_resume'])->middleware(['auth', 'verified'])->name('smart-resume');

Route::get('/smart-resume-builder',[UserDashboardController::class, 'smartResumeBuilder'])->middleware(['auth', 'verified'])->name('smartResumeBuilder');

Route::get('/career-paths', [UserDashboardController::class, 'career_paths'])->middleware(['auth', 'verified'])->name('career-paths');

Route::get('/mentorship', [UserDashboardController::class, 'mentorship'])->middleware(['auth', 'verified'])->name('mentorship');

Route::get('/recommended-books', [UserDashboardController::class, 'getRecommendedBooks'])->middleware(['auth', 'verified'])->name('recommended-books');

Route::get('/upskill',[UserDashboardController::class, 'upskill'])->middleware(['auth', 'verified'])->name('upskill');

Route::get('/surveys',[UserDashboardController::class, 'surveys'])->middleware(['auth', 'verified'])->name('surveys');
Route::post('/surveys/submit', [UserDashboardController::class, 'submitSurvey'])->name('surveys.submit');
Route::get('/upgrade',[UserDashboardController::class, 'upgrade'])->middleware(['auth', 'verified'])->name('upgrade');


Route::get('/api/user-recommendations', [UserDashboardController::class, 'fetchRecommendations'])->middleware(['auth', 'verified'])->name('fetchRecommendations');


Route::get('/settings', [UserDashboardController::class, 'settings'])->name('settings');
Route::post('/settings/update', [UserDashboardController::class, 'updateSettings'])->name('settings.update');

Route::get('/profile',[UserDashboardController::class, 'profile'])->middleware(['auth', 'verified'])->name('profile');

Route::post('/user/update-profile',[UserDashboardController::class, 'updateProfile'])->middleware(['auth', 'verified'])->name('updateProfile');
// routes/web.php

Route::post('/surveys/submit', [SurveyController::class, 'submit'])->name('surveys.submit');

// User route to view available courses
Route::get('/dashboard/courses', [UserDashboardController::class, 'courses'])->middleware(['auth', 'verified'])->name('user.dashboard.courses');



Route::get('/skill-gap-report', [UserDashboardController::class, 'skillGapReport'])->name('skill-gap.report');

// User Dashboard Controller end

Route::middleware(['auth'])->group(function () {
    Route::get('/upload-data', [UserDashboardController::class, 'showUploadData'])->name('upload.data.form');
    Route::post('/upload-data', [UserDashboardController::class, 'uploadUserData'])->name('uploadUserData');
});

// Login with Google routes

Route::get('auth/google',[GoogleController::class, 'googlepage']);
Route::get('auth/google/callback',[GoogleController::class, 'googlecallback']);

// Login with Google routes Ending


//Profile Controller

Route::post('/save-profile', [ProfileController::class, 'store']);

Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('settings.update.password');


Route::middleware(['auth'])->group(function () {
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



//SubscriptionController
Route::get('/upgrade/payment', [SubscriptionController::class, 'showPayment'])->name('subscription.payment');

Route::post('/upgrade/payment', [SubscriptionController::class, 'processPayment'])->name('subscription.process');
Route::get('/upgrade/thankyou', [SubscriptionController::class, 'thankYou'])->name('subscription.thankyou');
