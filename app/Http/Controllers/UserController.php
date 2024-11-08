<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\Factory; // Import for Factory
use Illuminate\Http\JsonResponse; 
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Startup;
use App\Models\Startupinverstor;
use App\Models\Job;
use App\Models\JobApplied;
use App\Models\User;
use App\Models\Donation;
use App\Models\UserProfile;


class UserController extends Controller
{
    // In your UserController.php
    public function getJobs(Request $request)
    {
        $searchQuery = $request->input('search', '');

    // Get all jobs matching the search query
    $jobs = Job::where('job_title', 'like', '%' . $searchQuery . '%')
                ->orWhere('job_description', 'like', '%' . $searchQuery . '%')
                ->orWhere('job_location', 'like', '%' . $searchQuery . '%')
                ->get();

    // If the request is an AJAX request, return the jobs as JSON response
    if ($request->ajax()) {
        return response()->json($jobs);
    }

    // Otherwise, return the jobs as a view
    return view('user.job-search', compact('jobs'));
    }
    
public function showUserDataInRazorPay()
{
    $user = Auth::user(); // Get the authenticated user
    return view('crowdfunding', ['user' => $user]);
}

// Get crowdfunding startups with optional search functionality
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

    // Fetch startups and calculate total donations
    $startups = $query->get()->map(function ($startup) {
        $totalDonations = Donation::where('company_id', $startup->id)->sum('donated_amount');
        $startup->total_donations = $totalDonations; // Add the total donations to the startup object
        return $startup;
    });

    if ($request->ajax()) {
        return response()->json($startups);
    } else {
        return view('user.Crowdfund', ['startups' => $startups]);
    }
}

// Save a donation
public function saveDonation(Request $request)
{
    $request->validate([
        'company_id' => 'required|exists:startups,id',
        'company_name' => 'required|string',
        'user_name' => 'required|string',
        'user_email' => 'required|email',
        'title' => 'required|string',
        'donated_amount' => 'required|numeric|min:0.01',
        'transaction_id' => 'required|string|unique:donations,transaction_id',
    ]);

    // Save the donation data
    $donation = new Donation();
    $donation->company_id = $request->company_id;
    $donation->company_name = $request->company_name;
    $donation->user_name = $request->user_name;
    $donation->user_email = $request->user_email;
    $donation->title = $request->title;
    $donation->donated_amount = $request->donated_amount;
    $donation->transaction_id = $request->transaction_id;
    $donation->save();

    return response()->json(['success' => true, 'message' => 'Donation saved successfully']);
}
public function showDonations(Request $request)
{
    // Fetch donations made by the currently authenticated user
    $donations = Donation::where('user_email', Auth::user()->email)->get();

    // Check if the request expects JSON
    if ($request->ajax()) {
        // Return donations as JSON for AJAX requests
        return response()->json($donations);
    }

    // Return the view with the donations for non-AJAX requests
    return view('user.donation-details', compact('donations'));
}
public function showDonation($id)
{
    $donation = Donation::with('startup')->findOrFail($id);

    // Check if startup data is available and access safely
    $startup = Startup::first();

$startupDescription = $startup->description; // Access the description attribute
$pdfUrl = $startup->pdf_file; 

    // Debug: Log or dd() to confirm if data is being retrieved
    if (!$donation->startup) {
        // Log or display error message if startup data is missing
        \Log::info("No associated startup found for donation ID: $id");
    }

    // Prepare the response data
    $responseData = [
        'id' => $donation->id,
        'company_name' => $donation->company_name,
        'title' => $donation->title,
        'description' => $startupDescription,
        'pdf_url' => $pdfUrl,
        'donated_amount' => $donation->donated_amount,
        'total_amount' => $donation->total_amount,
        'transaction_id' => $donation->transaction_id,
        'created_at' => $donation->created_at,
        'message' => $donation->message,
    ];

    // Check if the request expects a JSON response
    if (request()->expectsJson()) {
        return response()->json($responseData);
    }

    // If not, return a view with the donation data
    return view('user.donationdetails', compact('donation', 'responseData'));
}
// UserController.php
public function applyJob($job_id)
{
    // Fetch the job post details based on the job_id
    $job = Job::find($job_id);

    // Check if the job post exists
    if (!$job) {
        return redirect()->back()->withErrors(['error' => 'Job post not found.']);
    }

    // Pass the job details to the view
    return view('user.job_application', [
        'job' => $job
    ]);
}
   // UserController.php
public function storeJobApplication(Request $request)
{
    // Get the authenticated user
    $user = Auth::user();

    // Validate the form data
    $validatedData = $request->validate([
        'phone' => 'required|string|max:15',
        'degree' => 'required|string|max:255',
        'skills' => 'required|string|max:1000',
        'experience' => 'required|string|max:1000',
        'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        'job_id' => 'required|integer',
        'company_name' => 'required|string',
        'job_title' => 'required|string'
    ]);

    // Handle the resume file upload
    $resumeFileName = null;
    if ($request->hasFile('resume')) {
        $resume = $request->file('resume');
        $resumeFileName = time() . '.' . $resume->getClientOriginalExtension();
        $resume->move(public_path('resumes'), $resumeFileName);
    }

    // Save the job application in the database
    $jobApplication = new JobApplied(); // Assuming you have a model named JobApplied
    $jobApplication->name = $user->name;
    $jobApplication->email = $user->email;
    $jobApplication->company_name = $validatedData['company_name'];
    $jobApplication->job_title = $validatedData['job_title'];
    $jobApplication->phone = $validatedData['phone'];
    $jobApplication->degree = $validatedData['degree'];
    $jobApplication->skills = $validatedData['skills'];
    $jobApplication->experience = $validatedData['experience'];
    $jobApplication->resume = $resumeFileName ? 'resumes/' . $resumeFileName : null;
    $jobApplication->job_id = $validatedData['job_id'];

    $jobApplication->save();

    // Return a JSON response indicating success
    return response()->json([
        'success' => true,
        'message' => 'Job application submitted successfully!'
    ]);
}

//fetcappliedjobs
public function getAppliedJobs()
{
    // Check if the user is authenticated
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to view your applied jobs.');
    }

    // Get the current user's email
    $currentEmail = Auth::user()->email;

    // Fetch records from the JobApplied model where the email matches
    $appliedJobs = JobApplied::where('email', $currentEmail)->get();

    // Check if the request is an AJAX request
    if (request()->wantsJson()) {
        // Return the result as JSON
        return response()->json($appliedJobs);
    }

    // Return the result as a view
    return view('user.jobapplied', ['appliedJobs' => $appliedJobs]);
}
public function show($job_id)
{
    // Fetch the job application details
    $jobApplied = JobApplied::where('job_id', $job_id)->firstOrFail();

    // Fetch the job details from the jobs table
    $job = Job::findOrFail($jobApplied->job_id);

    // Check if the request is an AJAX request
    if (request()->ajax()) {
        return response()->json($job);
    }

    // Pass the job data to the view for non-AJAX requests
    return view('user.jobdetails', ['job' => $job]);
}public function getSuggestions(Request $request)
{
    $query = $request->input('query');
    
    // Fetch job titles that match the query (case-insensitive search)
    $suggestions = Job::where('job_title', 'like', '%' . $query . '%')
        ->distinct()
        ->pluck('job_title');
    
    // If the request is AJAX, return JSON response
    if ($request->ajax()) {
        return response()->json([
            'suggestions' => $suggestions
        ]);
    }

    // Otherwise, return a view with the suggestions for normal requests
    return view('user.body', compact('suggestions'));
}

public function searchJobs(Request $request)
{
    $searchTerm = $request->input('search'); // Get the search term from the input field

    // Query the jobs table to find job titles that match the search term
    $jobs = Job::where('job_title', 'LIKE', '%' . $searchTerm . '%')->get();
    if ($request->ajax()) {
        // Return the jobs data as JSON for the AJAX response
        return response()->json([
            'jobs' => $jobs
        ]);
    }
    // Pass the search term and job results to the view
    return view('user.result', compact('jobs', 'searchTerm'));
}

/**
 * Display job search results on a separate page.
 */
public function showResults(Request $request)
{
    $jobs = session('jobs', []); // Retrieve jobs from session
    $searchTerm = $request->input('search'); // Get search term from URL

    return view('job.results', compact('jobs', 'searchTerm'));
}
// Method to display the job details
    public function showJobDetails($id, Request $request)
    {
        // Fetch the job from the database by its ID
        $job = Job::find($id);

        // Check if job exists
        if ($job) {
            // If it's an AJAX request, return JSON response
            if ($request->ajax()) {
                return response()->json([
                    'id' => $job->id,
                    'job_title' => $job->job_title,
                    'job_description' => $job->job_description,
                    'company_name' => $job->company_name,
                    'job_location' => $job->job_location,
                    'salary' => $job->salary,
                ]);
            }

            // If it's a normal request, return the view with job data
            return view('user.job-detail', compact('job'));
        } else {
            // Return error response if job not found
            return response()->json([
                'error' => 'Job not found'
            ], 404);
        }
    }public function showProfileForm()
    {
        $user = Auth::user(); // Get the authenticated user
        return view('user.profile', compact('user')); // Pass the user data to the view
    }

    public function checkAndStoreProfile(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'headline' => 'required|string|max:255',
        'skills' => 'required|string|max:255',
        'file' => 'nullable|mimes:pdf,doc,docx|max:10240', // Validate resume
        'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate profile picture
    ]);

    // Handle the resume upload (if file is provided)
    $filePath = null;
    if ($request->hasFile('file')) {
        // Store the file in 'resumes' directory within public storage
        $filePath = $request->file('file')->store('public/resumes');
    }

    // Handle the profile picture upload
    $profilePicPath = $request->file('profile_pic')->store('public/profile_pictures');

    // Store the user's profile data
    $userProfile = UserProfile::updateOrCreate(
        ['user_id' => auth()->id()], // Update existing profile or create a new one
        [
            'username' => auth()->user()->name,
            'email' => auth()->user()->email,
            'headline' => $request->headline,
            'website' => $request->website,
            'linkedin_id' => $request->linkedin_id,
            'description' => $request->description,
            'experience' => $request->experience,
            'education' => $request->education,
            'skills' => $request->skills,
            'file' => $filePath,
            'profile_pic' => $profilePicPath,
        ]
    );

    return response()->json([
        'success' => true,
        'profile' => $userProfile,
    ]);
}

    public function showProfileDetails()
    {
        // Get the user's profile details from the database
        $userProfile = UserProfile::where('user_id', Auth::id())->first();

        // Return profile details as a JSON response
        return response()->json([
            'profile' => $userProfile
        ]);
    }
}