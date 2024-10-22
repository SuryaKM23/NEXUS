<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Startup;
use App\Models\Investor;
use App\Models\Startupinverstor;
use Hash;

class AdminController extends Controller
{
    public function view_form()
    {
        return view('admin.adduser');
    }


    public function add_form(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
    
        try {
            // Create a new User instance
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->usertype = 'admin'; // Set usertype to 'admin'
            $user->save();
    
            // Return a JSON response with the user data
            return response()->json([
                'success' => true,
                'message' => 'User added successfully',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            // Handle any errors that may occur
            return response()->json([
                'success' => false,
                'message' => 'There was an error adding the user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    


    //startup deatils fetch 
    public function startup_details(Request $request)
    {
        try {
            // Fetch data where usertype is 'investor' and status is 'accepted'
            $data = Startupinverstor::where('usertype', 'startup')
                            ->where('status', 'accepted')
                            ->get();

            // Check if the request is AJAX
            if ($request->ajax()) {
                return response()->json(['data' => $data]);
            } else {
                // If not AJAX, return a view with the data
                return view('admin.startup_details', compact('data'));
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            if ($request->ajax()) {
                // If AJAX, return JSON with error message
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                // If not AJAX, return a view with an error message
                return view('error_page', ['error' => $e->getMessage()]);
            }
        }
    }   


    //investor details fetch 

    public function investor_details(Request $request)
    {
        try {
            // Fetch data where usertype is 'investor' and status is 'accepted'
            $data = Startupinverstor::where('usertype', 'investor')
                            ->where('status', 'accepted')
                            ->get();

            // Check if the request is AJAX
            if ($request->ajax()) {
                return response()->json(['data' => $data]);
            } else {
                // If not AJAX, return a view with the data
                return view('admin.investor_details', compact('data'));
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            if ($request->ajax()) {
                // If AJAX, return JSON with error message
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                // If not AJAX, return a view with an error message
                return view('error_page', ['error' => $e->getMessage()]);
            }
        }
    }    


    // over all accept and reject code

    public function accept_page()//ere i want to fecth the details startupinvestor
    {
        $data = Startupinverstor::all();
        if(request()->expectsJson()){
            return response()->json([
               'sucess'=>true,
               'message'=>'startupdetails fetched',
               'data'=>$data,
            ]);
           }else{
          return view('admin.accept', compact('data'));
           }
    }

    public function accept(Request $request, $id) {
        try {
            // Find the StartupInvestor by ID
            $startupInvestor = Startupinverstor::find($id);
    
            // Check if the StartupInvestor exists
            if (!$startupInvestor) {
                return response()->json([
                    'error' => 'Startup investor not found'
                ], 404);
            }
    
            // Update status to 'accepted'
            $startupInvestor->status = 'accepted';
            $startupInvestor->save();
    
            // Fetch company details from StartupInvestor
            $Name = $startupInvestor->company_name;
            $email = $startupInvestor->email;
            $password = $startupInvestor->password; // Assuming this is already hashed in your database
            $userType = $startupInvestor->usertype;
            $company_name=$startupInvestor->company_name;
    
            // Create a User record
            $user = new User();
            $user->name = $Name; // Assuming the company name is used for user's name
            $user->email = $email;
            $user->password = Hash::make($password); // Hash the password securely
            $user->usertype = $userType;
            $user->startup_investor_id = $startupInvestor->id;
            $user->company_name=$company_name;
            $user->save();
    
            return response()->json([
                'message' => 'Startup investor accepted successfully and user created',
                'user' => $user,
                'startupInvestor' => $startupInvestor
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error accepting startup investor',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    //admin sit accpect reject code here

    public function acceptc(Request $request, $id)
{
    try {
        // Fetch the Startupinverstor by ID
        $startupInvestor = Startupinverstor::find($id);
        
        if (!$startupInvestor) {
            return response()->json(['success' => false, 'message' => 'Startup/Investor not found.'], 404);
        }

        // Update the status
        $startupInvestor->status = 'accepted';
        $startupInvestor->save();
        
        // Fetch necessary data from Startupinverstor instance
        $name = $startupInvestor->name;
        $company_name = $startupInvestor->company_name;
        $email = $startupInvestor->email;
        $phone = $startupInvestor->phone;
        $address = $startupInvestor->address;
        $country = $startupInvestor->country;
        $licenseNo = $startupInvestor->license_no;
        $usertype = $startupInvestor->usertype;
        $password = $startupInvestor->password; // Assuming 'role' is the correct attribute
        $website = $startupInvestor->website;
        $profile_picture = $startupInvestor->profile_picture;
        
        // Check if the user with the same email already exists
        if (User::where('email', $email)->exists()) {
            return response()->json(['success' => false, 'message' => 'Email already exists in the system.'], 400);
        }
        
        // Create a new user in the users table
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        // Example: Generating a random password
        $user->password = bcrypt($password); // Ensure to hash the password securely
        $user->usertype = $usertype;
        $user->startup_investor_id = $id;
        $user->company_name=$company_name;
         // Assuming the relationship
        $user->save();
        
        // Prepare success message based on role
        $successMessage = 'Successfully accepted Startup/Investor details and created a user.';

        // Return a success JSON response
        return response()->json(['success' => true, 'message' => $successMessage]);
    } catch (\Exception $e) {
        // Return an error JSON response
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}


public function reject($id)
{
    try {
        // Fetch the Startupinverstor by ID
        $startupInvestor = Startupinverstor::findOrFail($id);

        // Update the status in the Startupinverstor table
        $startupInvestor->status = 'rejected';
        $startupInvestor->save(); // Save the changes

        // Fetch the User record using startup_investor_id
        
        $user = User::where('startup_investor_id', $id)->firstOrFail();

        // Delete the user record
        $user->delete();

        // Return a success JSON response
        return response()->json(['success' => true, 'message' => 'Startup/Investor status updated and user deleted successfully.']);
    } catch (\Exception $e) {
        // Return an error JSON response
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}


}
