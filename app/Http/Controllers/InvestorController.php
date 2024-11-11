<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\Startup;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function getCrowdfundingVC(Request $request)
    {
        $search = $request->input('search');
        $query = Startup::where('investment', 'vc');
    
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%$search%")
                  ->orWhere('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }
    
        $startups = $query->get();
    
        if ($request->ajax()) {
            return response()->json($startups);
        } else {
            return view('user.Crowdfund', ['startups' => $startups]);
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

}
