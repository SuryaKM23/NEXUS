<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Startup;
use App\Models\Startupinverstor;
use App\Models\User;// Adjust this to match your Startup model namespace

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
        'account_number' => $request->investment === 'crowdfunding' ? 'required|string|max:20' : 'nullable|string',
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
    // Retrieve company name from session
    $companyName = Session::get('company_name');

    // Query the database for the three most recent records filtered by company name
    $recentIdeas = Startup::where('company_name', $companyName)
        ->orderBy('created_at', 'desc') // Sort by 'created_at' column in descending order
        ->take(3) // Limit to the most recent three records
        ->get();

    // Return the recent ideas as a JSON response for AJAX
    return response()->json($recentIdeas);
}

}