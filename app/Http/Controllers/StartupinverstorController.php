<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Startupinverstor; // Corrected import statement
use Illuminate\Support\Facades\Validator;

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
       
}
