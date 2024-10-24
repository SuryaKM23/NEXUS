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


}
