<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function showProfile(): View
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;

            // Return views based on usertype
             if ($usertype == 'user') {
                return view('user.profiledetails');
            } elseif ($usertype == 'startup' ) {
                return view('startup.profiledetails');
            } 
            elseif($usertype=='investor'){
                return view('investor.profiledetails');
            }
            else {
                // Handle unexpected user types
                return view ('admin.profile');
            }
        }

        // If the user is not authenticated, redirect to login
        return redirect()->route('login');
    }
}