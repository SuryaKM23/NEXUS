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
use App\Models\User;// Adjust this to match your Startup model namespace
use App\Models\UserProfile;

class StartupController extends Controller
{
    public function post_ideas()
    {
        {
            // Get the startup_investor_id from the session
            $startup_investor_id = Session::get('startup_investor_id');
    
            // Fetch the Startupinverstor record and get the company name
            $startup_investor = Startupinverstor::find($startup_investor_id);
            if ($startup_investor) {
                $companyName = $startup_investor->company_name;

               // Add any other details you need
            } 
      Session::put('company_name', $companyName);
            // Pass the company name to the view
            return view('startup.post_ideas', compact('companyName'));
        }
    }
    public function get_ideas(Request $request)
{
    // Ensure the user is authenticated
    // Validate incoming request data
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'estimated_amount' => 'required|numeric|min:0',
        'estimated_turn_over' => 'required|numeric|min:0',
        'date_of_posting' => 'required|date',
        'investment' => 'required|string|max:12',
        'pdf_file' => 'required|file|max:10240', // Ensure file is uploaded
        // Only validate banking details if crowdfunding is selected
        'account_holder_name' => $request->investment === 'crowdfunding' ? 'required|string|max:255' : 'nullable|string',
        'account_number' => $request->investment === 'crowdfunding' ? 'required|string|between:11,16' : 'nullable|string',
        'bank_name' => $request->investment === 'crowdfunding' ? 'required|string|max:255' : 'nullable|string',
        'ifsc_code' => $request->investment === 'crowdfunding' ? 'required|string|max:11' : 'nullable|string',
        'swift_code' => 'nullable|string|max:11',
        'upi_id' => 'nullable|string|max:255',
    ]);

    // Retrieve company name from session
    $companyName = Session::get('company_name');
    
    // Handle the PDF file upload
    $pdfFileName = null;
    if ($request->hasFile('pdf_file')) {
        $pdf = $request->file('pdf_file');
        $pdfFileName = time() . '.' . $pdf->getClientOriginalExtension();
        $pdf->move(public_path('pdf_file'), $pdfFileName);
    }

    // Create a new instance of Startup model and save the idea
    $idea = new Startup();
    $idea->company_name = $companyName;
    $idea->title = $validatedData['title'];
    $idea->description = $validatedData['description'];
    $idea->estimated_amount = $validatedData['estimated_amount'];
    $idea->estimated_turn_over = $validatedData['estimated_turn_over'];
    $idea->date_of_posting = $validatedData['date_of_posting'];
    $idea->investment = $validatedData['investment'];
    $idea->pdf_file = $pdfFileName ? 'pdf_file/' . $pdfFileName : null;

    // Save banking details if provided
    $idea->bank_name = $validatedData['bank_name'] ?? null;
    $idea->account_holder_name = $validatedData['account_holder_name'] ?? null;
    $idea->account_number = $validatedData['account_number'] ?? null;
    $idea->ifsc_code = $validatedData['ifsc_code'] ?? null;
    $idea->swift_code = $validatedData['swift_code'] ?? null;
    $idea->upi_id = $validatedData['upi_id'] ?? null;

    // Save the idea to the database
    $idea->save();

    // Return a JSON response indicating success
    return response()->json([
        'success' => true,
        'message' => 'Idea posted successfully',
        'data' => $idea
    ], 200);
}

public function getRecentIdeas()
{
    // Retrieve the authenticated user's company name
    $userCompanyName = auth()->user()->company_name;

    // Query the database for the most recent records from the startup table
    // where the user's company name matches the startup company name
    $recentIdeas = Startup::where('company_name', $userCompanyName)
        ->orderBy('created_at', 'desc') // Sort by 'created_at' column in descending order
        ->take(3) // Limit to the most recent four records
        ->get();

    // Return the recent ideas as a JSON response for AJAX
    return response()->json($recentIdeas);
}

public function viewIdeas(): JsonResponse|view
{
    $userCompanyName = Auth::user()->company_name;

    $ideas = Startup::where('company_name', $userCompanyName)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($idea) {
            $idea->created_at = Carbon::parse($idea->created_at)->format('Y-m-d');
            return $idea;
        });

    // Check if the request is an AJAX request
    if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'data' => $ideas,
        ]);
    }

    // If it's not an AJAX request, return a view
    return view('startup.ideadetails', ['ideas' => $ideas]);
}

    // Delete idea by ID
    public function deleteIdea($id): JsonResponse
    {
        $idea = Startup::find($id);
        if (!$idea) {
            return response()->json(['success' => false, 'message' => 'Idea not found.'], 404);
        }

        $idea->delete();
        return response()->json(['success' => true, 'message' => 'Idea deleted successfully.']);
    }

    // Show edit form for the idea by ID
    public function editIdea($id)
    {
        $idea = Startup::find($id);
        if (!$idea) {
            return redirect()->back()->withErrors('Idea not found.');
        }

        return view('startup.EditIdeas', compact('idea'));
    }

    // Update idea by ID
    public function updateIdea(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'estimated_amount' => 'required|numeric',
            'estimated_turn_over' => 'required|numeric',
        ]);

        $idea = Startup::find($id);
        if (!$idea) {
            return response()->json(['success' => false, 'message' => 'Idea not found.'], 404);
        }

        $idea->update($validatedData);

        return response()->json(['success' => true, 'message' => 'Idea updated successfully.']);
    }
    //job

    public function showJobForm()
    {
        $currentUser = auth()->user(); // Get the currently authenticated user
        $companyName = $currentUser ? $currentUser->company_name : ''; // Fetch the company name

        return view('startup.post_job', compact('companyName')); // Pass the company name to the view
    }

    public function storeJobVacancy(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'job_description' => 'required|string',
            'job_location' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'application_deadline' => 'required|date',
            'job_type' => 'required|string',
            'experience_level' => 'required|string',
            'required_skills' => 'required|string',
        ]);

        $validatedData = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'job_description' => 'required|string',
            'job_location' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'application_deadline' => 'required|date',
            'job_type' => 'required|string',
            'experience_level' => 'required|string',
            'required_skills' => 'required|string',
        ]);
    
        // Create a new instance of the Job model
        try {
            // Create a new instance of the Job model
            $job = new Job();
            
            // Assign the validated data to the model's attributes
            $job->job_title = $validatedData['job_title'];
            $job->company_name = $validatedData['company_name'];
            $job->job_description = $validatedData['job_description'];
            $job->job_location = $validatedData['job_location'];
            $job->salary = $validatedData['salary'];
            $job->application_deadline = $validatedData['application_deadline'];
            $job->job_type = $validatedData['job_type'];
            $job->experience_level = $validatedData['experience_level'];
            $job->required_skills = $validatedData['required_skills'];
        
            // Save the job vacancy to the database
            $job->save();
    
            // Return JSON response for AJAX
            return response()->json([
                'success' => true,
                'message' => 'Job vacancy posted successfully!',
            ]);
    
        } catch (\Exception $e) {
            // Return error response in case of failure
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while posting the job vacancy!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getJobApplicationsByCompany()
{
    $companyName = session('company_name');

    // Check if companyName is available
    if (!$companyName) {
        $response = ['error' => 'Company name not found in session.'];
        
        // Check if the request expects JSON
        if (request()->wantsJson()) {
            return response()->json($response, 400);  // Send JSON response
        }
        
        // Otherwise, return the response in a view
        return view('startup.job_applications', ['error' => $response['error']]);
    }

    // Fetch all job applications where the company_name matches the current user's company name
    $appliedJobs = JobApplied::where('company_name', $companyName)->get();

    // Prepare the response data
    $responseData = $appliedJobs->isEmpty() ? ['message' => 'No job applications found for this company.'] : $appliedJobs;

    // If the request wants JSON, return JSON
    if (request()->wantsJson()) {
        return response()->json($responseData);
    }

    // If the request doesn't expect JSON, return the view
    return view('startup.job_applications', ['appliedJobs' => $appliedJobs, 'message' => $responseData['message'] ?? null]);
}


public function viewJobs(): JsonResponse|View
{
    // Get the current authenticated user
    $user = auth()->user();

    // Fetch jobs where company_name matches the user's company_name
    $jobs = Job::where('company_name', $user->company_name)
        ->orderBy('created_at', 'desc') // Optional: sort by created_at if needed
        ->get()
        ->map(fn($job) => $job->setAttribute('created_at', \Carbon\Carbon::parse($job->created_at)->format('Y-m-d'))); // Format created_at date

    if (request()->expectsJson()) {
        return response()->json([
            'success' => true,
            'data' => $jobs, // Return the fetched jobs with formatted date
        ], 200); // Return JSON response
    } else {
        return view('startup.viewjobs', compact('jobs')); // Render view
    }
}
public function editjob($id)
{
    // Fetch the startup data by ID
    $startup = Startup::find($id);
    
    if ($startup) {
        return view('startup.EditIdeas', compact('startup')); // Return the edit view with data
    }
    
    return redirect()->back()->withErrors('Idea not found.');
}
public function updateJob(Request $request, $id)
{
    // Validate the request data
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'estimated_amount' => 'required|numeric',
        'estimated_turn_over' => 'required|numeric',
        'company_name' => 'required|string|max:255',
        'job_location' => 'required|string|max:255',
        'salary' => 'required|string|max:255',
        'application_deadline' => 'required|date',
        'job_type' => 'required|string',
        'experience_level' => 'required|string',
        'required_skills' => 'required|string',
    ]);

    // Find the startup record by ID
    $startup = Startup::find($id);

    if ($startup) {
        // Update the startup record with validated data
        $startup->update($validatedData);
        return response()->json(['success' => true, 'message' => 'Job updated successfully.']); // Return success response
    }

    return response()->json(['success' => false, 'message' => 'Job not found.']); // Return error response
}

// Method to delete a job
public function deleteJob($id)
{
    // Find the job by ID
    $job = Job::find($id);

    if ($job) {
        $job->delete();
        return response()->json(['success' => true, 'message' => 'Job deleted successfully.']);
    }

    return response()->json(['success' => false, 'message' => 'Job not found.'], 404);
}
}