<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\Startup;
use App\Models\Startupinverstor;
use Illuminate\Http\Request;


class InvestorController extends Controller
{
    public function getCrowdfundingVC(Request $request)
    {
        // Get the search query from the request
        $searchQuery = $request->input('search');
        
        // Fetch only crowdfunding startups with investment type 'vc'
        $startups = Startup::where('investment', 'vc')
            ->where(function ($query) use ($searchQuery) {
                $query->where('company_name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            })
            ->get();
        
        // Check if the request is AJAX or not
        if ($request->ajax()) {
            // Return the data as JSON if the request is AJAX
            return response()->json($startups);
        } else {
            // Return the data in a view if it's a normal HTTP request
            return view('investor.fundraising', compact('startups'));
        }
    }

    public function showProfileDetails()
    {
        $user = Auth::user();
        $basicProfile = [
            'username' => $user->name,
            'email' => $user->email,
        ];
    
        // Retrieve the user's profile details from UserProfile
        $userProfile = UserProfile::where('user_id', $user->id)->first();
    
        // Merge basic profile with user profile details if available
        $profileData = $userProfile ? array_merge($basicProfile, $userProfile->toArray()) : $basicProfile;
    
        // Return profile details as a JSON response
        return response()->json([
            'profile' => $profileData
        ]);
    }

    public function editProfile()
    {
        $user = Auth::user(); // Assuming the user is authenticated
        return view('investor.Profile', compact('user'));
    }

    public function update(Request $request)
    {
        // Validation rules
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'headline' => 'required|string|max:255',
            'description' => 'required|string',
            'linkedin_id' => 'required|url',
            'profile_pic' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Profile picture validation
            'file' => 'required|mimes:pdf|max:2048', // Resume validation
        ]);
    
        // Fetch the authenticated user
        $user = Auth::user();
    
        // Initialize file names to null
        $profilePicFileName = null;
        $fileFileName = null;
    
        // Define paths for saving files
        $profilePicPath = 'profile_pictures/';
        $resumePath = 'resumes/';
    
        if ($request->hasFile('profile_pic')) {
            $profilePic = $request->file('profile_pic');
            $profilePicFileName = time() . '.' . $profilePic->getClientOriginalExtension();
            $profilePic->move(public_path($profilePicPath), $profilePicFileName); // Move the uploaded file to the profile_pictures directory
        }
    
        // Handle resume upload if exists
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileFileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($resumePath), $fileFileName); // Move the uploaded file to the resumes directory
        }
    
        // Update or create the user profile in the user_profiles table
        $userProfile = UserProfile::updateOrCreate(
            ['user_id' => $user->id], // Condition to check if profile exists
            [
                'username' => $request->username,
                'email' => $request->email,
                'headline' => $request->headline,
                'description' => $request->description,
                'linkedin_id' => $request->linkedin_id,
                'profile_pic' => $profilePicFileName, 
                'file' => $fileFileName,
            ]
        );
    
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.'
        ]);
    }

        // Method to fetch email from the startupinvestor table
        public function getStartupInvestorEmail(Request $request)
        {
            // Fetch the company name from the request
            $companyName = $request->input('company_name');
            
            // Query the StartupInvestor table for the email where company_name matches
            $startupInvestor = Startupinverstor::where('company_name', $companyName)->first();
        
            // Check if the record exists
            if ($startupInvestor) {
                // Return the email in the response
                return response()->json([
                    'email' => $startupInvestor->email
                ]);
            }
        
            // If no record found, return an error
            return response()->json([
                'error' => 'No startup found with the given company name.'
            ], 404);
        }
    }
    
