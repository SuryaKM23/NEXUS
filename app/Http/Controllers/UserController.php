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
}public function applyJob(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'phone' => 'required|string',
        'degree' => 'required|string',
        'skills' => 'required|string',
        'experience' => 'required|string',
        'resume' => 'required|file|mimes:pdf,doc,docx|max:2048', // Adjust as needed
    ]);

    // Store the uploaded resume
    if ($request->hasFile('resume')) {
        $file = $request->file('resume');
        $path = $file->store('resumes'); // Store in the 'resumes' directory

        // Create a new job application record
        JobApplied::create([
            'user_id' => $request->user()->id, // Assuming you have a user logged in
            'phone' => $validatedData['phone'],
            'degree' => $validatedData['degree'],
            'skills' => $validatedData['skills'],
            'experience' => $validatedData['experience'],
            'resume_path' => $path, // Store the path to the resume
        ]);

        return response()->json(['message' => 'Application submitted successfully!'], 200);
    }

    return response()->json(['message' => 'Resume upload failed.'], 500);
}
}