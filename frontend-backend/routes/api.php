<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LiveJobController;

// Define API route for fetching live jobs
Route::get('/live-jobs', [LiveJobController::class, 'getLiveJobs']);
