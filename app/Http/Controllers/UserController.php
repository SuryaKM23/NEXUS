<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\Factory; // Import for Factory
use Illuminate\Http\JsonResponse; 
use Illuminate\View\View;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Startup;
use App\Models\Startupinverstor;
use App\Models\Job;
use App\Models\JobApplied;
use App\Models\User;


class UserController extends Controller
{
    // In your UserController.php
public function getJobs(Request $request)
{

    $search = $request->input('search');

    // Fetch jobs filtered by title
    $jobs = Job::when($search, function ($query) use ($search) {
        return $query->where('job_title', 'like', '%' . $search . '%');
    })->get();

    return response()->json($jobs);
}
public function getCrowdfundingStartups(Request $request)
{
    $search = $request->input('search');
    $query = Startup::where('investment', 'crowdfunding');

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
// UserController.php
    public function applyJob()
    {
        return view('user.job_application'); // Ensure the view file exists
    }
    public function appliedJob(Request $request) 
    {
        // Debugging session data
        \Log::info('Session Data: ', session()->all());
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'phone' => 'required|string|max:15',
            'degree' => 'required|string|max:255',
            'skills' => 'required|string|max:1000',
            'experience' => 'required|string|max:1000',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048', // File validation
        ]);
        
        // Retrieve the user's name and email from the authenticated user
        $name = $user->name; // Get user name from the authenticated user
        $email = $user->email; // Get user email from the authenticated user
        
        // Check if name and email are null
        if (is_null($name) || is_null($email)) {
            return response()->json([
                'success' => false,
                'message' => 'User name or email is not available.'
            ], 400);
        }
        
        // Handle the resume file upload
        $resumeFileName = null;
        if ($request->hasFile('resume')) {
            $resume = $request->file('resume');
            $resumeFileName = time() . '.' . $resume->getClientOriginalExtension();
            $resume->move(public_path('resumes'), $resumeFileName);
        }
        
        // Create a new job application instance
        $jobApplication = new JobApplied(); // Assuming you have a model named JobApplied
        $jobApplication->name = $name; // Store user name
        $jobApplication->email = $email; // Store user email
        $jobApplication->phone = $validatedData['phone'];
        $jobApplication->degree = $validatedData['degree'];
        $jobApplication->skills = $validatedData['skills'];
        $jobApplication->experience = $validatedData['experience'];
        $jobApplication->resume = $resumeFileName ? 'resumes/' . $resumeFileName : null; // Set resume path
    
        // Save the job application to the database
        $jobApplication->save();
        
        // Return a JSON response indicating success
        return response()->json([
            'success' => true,
            'message' => 'Job application submitted successfully!',
            'data' => $jobApplication
        ]);
    }
    
    
}