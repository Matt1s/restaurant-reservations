<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    /**
     * Handle the logout request.
     */
    public function __invoke(Request $request)
    {
        // Check if user is actually logged in
        if (!Auth::check()) {
            return redirect('/')->with('message', 'You are already logged out.');
        }

        // Store user info for logging purposes if needed
        $userId = Auth::id();
        
        // Perform logout
        Auth::logout();
        
        // Invalidate the session
        $request->session()->invalidate();
        
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        
        // Flash session data before response
        Session::flash('message', 'You have been logged out successfully.');
        
        return redirect('/');
    }
}
