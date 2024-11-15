<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Donation;
use App\Models\Startup;

class IndexController extends Controller
{
    public function Index()
    {
        if (Auth::id())
        {
           $usertype = Auth()->user()->usertype;

           if ($usertype == 'admin') {

               return view('admin.adminhome');

           } elseif ($usertype == 'user') {

               return view('user.user_home');
               
           } elseif ($usertype =='startup') {

                return view('startup.startup_home');

           } elseif ($usertype =='investor') {

            return view('investor.investor_home');

           }

           else {
               // Handle other user types or unexpected cases
               return redirect()->back();
               
           }
       }  
    }


    public function view(){
        return view('home.registerform');
       }

       public function store(Request $request)
       {
           // Validate the incoming request data
           $request->validate([
               'name' => 'required|string|max:255',
               'company_name' => 'required|string|max:255',
               'email' => 'required|string|email|max:255|unique:users',
               'Phone' => 'required|string|max:15',
               'Address' => 'required|string|max:255',
               'Country' => 'required|string|max:255',
               'License_no' => 'required|string|max:255',
               'usertype' => 'required|string|in:startup,investor',
               'password' => 'required|string|min:8',
               'website' => 'required|string|url|max:255',
               'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           ]);
   
           // Handle the profile picture upload
           if ($request->hasFile('profile_picture')) {
               $image = $request->file('profile_picture');
               $profilePictureName = time() . '.' . $image->getClientOriginalExtension();
               $image->move(public_path('profile_pictures'), $profilePictureName);
           }
   
           // Store user data
           // Assuming you have a User model
           $user = User::create([
               'name' => $request->name,
               'company_name' => $request->company_name,
               'email' => $request->email,
               'phone' => $request->Phone,
               'address' => $request->Address,
               'country' => $request->Country,
               'license_no' => $request->License_no,
               'usertype' => $request->usertype,
               'password' =>$request->password,
               'website' => $request->website,
               'profile_picture' => $profilePictureName,
           ]);
   
           return response()->json([
               'message' => 'User registered successfully',
               'user' => $user
           ], 201);
       }

       public function getFactsCounts()
       {
           $activeUsersCount = User::count();
           $startupCompaniesCount = User::where('usertype', 'startup')->count();
           $totalContributions = Donation::sum('donated_amount');
           $innovativeIdeasCount = Startup::count();
       
           return response()->json([
               'activeUsersCount' => $activeUsersCount,
               'innovativeIdeasCount' => $innovativeIdeasCount,
               'startupCompaniesCount' => $startupCompaniesCount,
               'totalContributions' => $totalContributions
           ]);
       }
    }
