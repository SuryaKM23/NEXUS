<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Models\Startupinverstor; // Corrected import statement
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserProfile;
class StartupinverstorController extends Controller
{
    public function view(){
        return view('home.registerform');
       }

       public function createregister(Request $request)
       {
           // Validate the incoming request data
           $request->validate([
               'name' => 'required|string|max:255',
               'company_name' => 'required|string|max:255',
               'email' => 'required|string|email|max:255|unique:users',
               'phone' => 'required|string|max:15',
               'address' => 'required|string|max:255',
               'country' => 'required|string|max:255',
               'license_no' => 'required|string|max:255',
               'usertype' => 'required|string|in:startup,investor',
               'password' => 'required|string|min:8',
               'website' => 'required|string|url|max:255',
               'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           ]);
       
          
           // Store user data
           $startupinvestor = new Startupinverstor;
           $startupinvestor->name = $request->name;
           $startupinvestor->company_name = $request->company_name;
           $startupinvestor->email = $request->email;
           $startupinvestor->phone = $request->phone;
           $startupinvestor->address = $request->address;
           $startupinvestor->country = $request->country;
           $startupinvestor->license_no = $request->license_no;
           $startupinvestor->usertype = $request->usertype;
           $startupinvestor->password =$request->password; // Hash the password
           $startupinvestor->website = $request->website;
        //    $startupinvestor->profile_picture = $profilePictureName;
       
            // Handle the profile picture upload
            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $profilePictureName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('profile_pictures'), $profilePictureName);
            
                // Assuming $startupinvestor is your model instance
                $startupinvestor->profile_picture = 'profile_pictures/' . $profilePictureName;
                $startupinvestor->save(); // Save the model with the updated profile picture path
            }
            
       
           return response()->json([
               'message' => 'User registered successfully',
               'startupinvestor' => $startupinvestor
           ], 201);
       }
       
       public function showProfileDetails()
       {
           // Get the user's basic details from the Auth
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
           return view('Profile_Startup_investor.editprofile', compact('user'));
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