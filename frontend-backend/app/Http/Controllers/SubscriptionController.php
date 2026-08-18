<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function showPayment() {
        return view('user-dashboard.payment');
    }
    

    public function processPayment(Request $request)
    {
        // Simulate a successful payment (you can add validation logic here)
        
        // Update user subscription in DB
        $user = Auth::user();
        $user->subscription_status = 'premium'; // you must have this column in users table
        $user->save();

        return redirect()->route('subscription.thankyou');
    }

    public function thankYou()
    {
        return view('user-dashboard.thankyou');
    }
}
