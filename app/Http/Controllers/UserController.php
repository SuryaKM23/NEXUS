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
        $job = Job::findOrFail($job_id);

        // Pass the job data to the view
        return view('user.jobdetails', ['job' => $job]);
    }

}