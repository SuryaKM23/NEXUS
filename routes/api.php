<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StartupController;

use App\Http\Controllers\StartupinverstorController;
use App\Http\Controllers\InvestorController;
Use App\Http\Controllers\IndexController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/add_form',[AdminController::class,'add_form']);


Route::middleware('auth:sanctum')->get('/startup', function (Request $request) {
    return $request->startup();
});

// Route::post('/add_info', [StartupController::class, 'add_info']);

// register part

Route::get('/startupregister',[StartupinverstorController::class,'view']);
Route::post('/createregister' ,[StartupinverstorController::class,'createregister'])->name('createregister');

//admin
Route::get('/admin/dashboard/fetch-stats', [AdminController::class, 'fetchDashboardStats']);
// Route::get('/view_form',[AdminController::class,'view_form']);
// Route::post('/add_form',[AdminController::class,'add_form']);
// Route::get('/show_form',[AdminController::class,'show_form']);
Route::get('/startup_details',[AdminController::class,'startup_details']);
Route::get('/investor_details',[AdminController::class,'investor_details']);
Route::get('/accept_page',[AdminController::class,'accept_page']);//fetch startup details
Route::post('/accept_startupinvestor/{id}',[AdminController::class,'accept']);
Route::post('/accept/{id}', [AdminController::class, 'acceptc'])->name('accept');//admin sit accpect the startup investor deatils
Route::post('/reject/{id}', [AdminController::class, 'reject'])->name('reject');


// Startup
Route::get('/post_ideas', [StartupController::class, 'post_ideas']);
Route::post('/get_ideas', [StartupController::class, 'get_ideas'])->name('get_ideas');
Route::get('/viewIdeas',[StartupController::class,'view_Ideas']);
Route::get('/viwepost_jobs',[StartupController::class,'view_jobs']);

//last 3 ideas
Route::get('/get-recent-ideas', [StartupController::class, 'getRecentIdeas']);
//idea edit-update-delete
// Route for fetching ideas
Route::get('/IdeasDetails', [StartupController::class, 'viewIdeas'])->name('view.ideas');

// Route for deleting an idea
Route::delete('/delete-Idea/{id}', [StartupController::class, 'deleteIdea'])->name('delete.idea');

// Route for updating an idea
Route::put('/update-Idea/{id}', [StartupController::class, 'updateIdea'])->name('update.idea');


//JobPost
Route::get('/post_job', [StartupController::class, 'showJobForm'])->name('post_job');
Route::post('/post-job-vacancy', [StartupController::class, 'storeJobVacancy'])->name('post.job.vacancy');


// Route to fetch recent jobs
Route::get('/viewJobs', [StartupController::class, 'viewJobs']);
Route::get('/edit-job/{id}', [StartupController::class, 'editjob'])->name('edit.job');
// Route to update the job
Route::put('/update-job/{id}', [StartupController::class, 'updatejob'])->name('update.job');
// Route to delete a job
Route::delete('/delete-job/{id}', [StartupController::class, 'deleteJob']);


Route::get('/profile_details', [StartupController::class, 'showProfileDetails'])->name('profiles.details');

// Show edit profile page
Route::get('/profile_edit', [StartupController::class, 'editProfile'])->name('profiles.edit');

// Update profile details
Route::put('/profile_update', [StartupController::class, 'update'])->name('profiles.update');


Route::get('/show_profile/{email}', [StartupController::class, 'show_profile']);

Route::get('/profile_detail/{email}', [StartupController::class, 'show_profile_other']);

Route::get('/fetch-company-name', [StartupController::class, 'fetchCompanyName'])->name('fetch.company.name');

Route::get('/profile/{company_name}', [StartupController::class, 'profilecompany']);
Route::get('/profile_/{company_name}', [StartupController::class, 'profile_company']);


//Investor

Route::get('/get-crowdfunding-vc', [InvestorController::class, 'getCrowdfundingVC']);
Route::get('/search-crowdfunding-vc', [InvestorController::class, 'searchCrowdfundingVC']);

Route::get('/profile-details', [InvestorController::class, 'showProfileDetails'])->name('pro.details');

// Show edit profile page
Route::get('/profile-edit', [InvestorController::class, 'editProfile'])->name('pro.edit');

// Update profile details
Route::put('/profile-update', [InvestorController::class, 'update'])->name('pro.update');
Route::get('/get-startup-investor-email', [InvestorController::class, 'getStartupInvestorEmail']);



//User


Route::get('/get-jobs',[UserController::class,'getJobs']);
Route::get('/job-suggestions', [UserController::class, 'getSuggestions'])->name('search.suggestions');
Route::get('/job-search', [UserController::class, 'searchJobs'])->name('search.jobs');
Route::get('/job-results', [UserController::class, 'showResults'])->name('job.results');

Route::get('/job-detail/{id}', [UserController::class, 'showJobDetails'])->name('job.detail');
//crowdfing
Route::get('/getcrowdfundingstartups', [UserController::class, 'getCrowdfundingStartups']);
Route::get('/crowdfunding', [UserController::class, 'showUserDataInRazorPay']);
Route::post('/save-donation', [UserController::class, 'saveDonation'])->name('save.donation');
Route::get('/donation', [userController::class, 'showDonations'])->name('donation.detail');
Route::get('/donation/details/{id}', [UserController::class, 'showdonation']);
// Route to show job application form
Route::get('/apply_job/{job_id}', [UserController::class, 'applyJob']);


// Route to handle the form submission
// web.php
Route::middleware('auth')->post('/applied_job', [UserController::class, 'storeJobApplication']);

Route::get('/get-applied-jobs', [UserController::class, 'getAppliedJobs'])->name('get.applied.jobs');
Route::get('/job/details/{job_id}', [UserController::class, 'show'])->name('job.details');


Route::get('/profile/detail', [UserController::class, 'showProfileDetails'])->name('user.profile.details');
Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
Route::put('/profile/update', [UserController::class, 'update'])->name('user.profile.update');



Route::post('/login',[IndexController::class,'login']);
Route::post('/register',[IndexController::class,'register']);