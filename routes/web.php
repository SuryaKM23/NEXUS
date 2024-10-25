<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StartupController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\StartupinverstorController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/',[FrontController::class,'frontpage']);

Route::get('/startupregister',[StartupinverstorController::class,'view']);
Route::post('/createregister' ,[StartupinverstorController::class,'createregister'])->name('createregister');

Route::get('/Home',[IndexController::class,'Index']);
// Route::get('/startup/home',[IndexController::class,'startup_home']);
// Route::get('/investor/home',[InvestorController::class,'investor_home']);

//register part
Route::get('/startupinverstor_register',[StartupinverstorController::class,'viewregister']);
Route::post('/createstartup',[StartupinverstorController::class,'createstartup']);


//admin part




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/view_form',[AdminController::class,'view_form']);
Route::post('/add_form',[AdminController::class,'add_form']);
Route::get('/show_form',[AdminController::class,'show_form']);
Route::get('/details_manager',[AdminController::class,'details_manager']);
Route::get('/delete_details/{id}',[AdminController::class,'delete_details']);
Route::get('/editdetails/{id}',[AdminController::class,'edit_details']);
Route::post('/update_user/{id}',[AdminController::class,'update_user']);
Route::get('/startup_details',[AdminController::class,'startup_details']);
Route::get('/investor_details',[AdminController::class,'investor_details']);

Route::get('/accept_page',[AdminController::class,'accept_page']);//fetch startup details
Route::post('/accept_startupinvestor/{id}',[AdminController::class,'accept']);


Route::post('/accept/{id}', [AdminController::class, 'acceptc'])->name('accept');//admin sit accpect the startup investor deatils
Route::post('/reject/{id}', [AdminController::class, 'reject'])->name('reject');

//startup 
Route::get('/post_ideas', [StartupController::class, 'post_ideas']);
Route::post('/get_ideas', [StartupController::class, 'get_ideas'])->name('get_ideas');
Route::get('/viewIdeas',[StartupController::class,'view_Ideas']);
Route::get('/viwepost_jobs',[StartupController::class,'view_jobs']);

//last 3 ideas
Route::get('/get-recent-ideas', [StartupController::class, 'getRecentIdeas']);
//idea edit-update-delete
Route::delete('/delete-idea/{id}', [StartupController::class, 'deleteIdea']);//delete
Route::get('/edit-idea/{id}', [StartupController::class, 'editidea'])->name('edit.idea');//edit
Route::put('/update-idea/{id}', [StartupController::class, 'updateidea'])->name('update.idea');//update
//JobPost
Route::get('/post_job', [StartupController::class, 'showJobForm'])->name('post_job');
Route::post('/post-job-vacancy', [StartupController::class, 'storeJobVacancy'])->name('post.job.vacancy');


//job fetch
Route::get('/get-jobs', [UserController::class, 'getJobs']);
//crowdfing
Route::get('/get-crowdfunding-startups', [UserController::class, 'getCrowdfundingStartups']);

// Route to show job application form
Route::get('/apply_job', [UserController::class, 'applyJob']);

// Route to handle the form submission
Route::middleware('auth')->post('/applied_job', [UserController::class, 'appliedJob']);


require __DIR__.'/auth.php';
