<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StartupController;

use App\Http\Controllers\StartupinverstorController;


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
Route::post('/createregister' ,[StartupinverstorController::class,'createregister']);
Route::post('/accept_startupinvestor/{id}',[AdminController::class,'accept']);
Route::post('accept/{id}', [AdminController::class, 'accept']);


//admin side
Route::get('/accept_page',[AdminController::class,'accept_page']);//fetch startup details
Route::get('/investor_details', [AdminController::class, 'investor_details']);

//post_idea
Route::post('/get_ideas',[StartupController::class,'get_ideas']);

//startup 
Route::get('/post_ideas', [StartupController::class, 'post_ideas']);
Route::post('/get_ideas', [StartupController::class, 'get_ideas'])->name('get_ideas');
Route::get('/viwepost_jobs',[StartupController::class,'view_jobs']);

Route::get('/get-recent-ideas', [StartupController::class, 'getRecentIdeas']);
Route::delete('delete-idea/{id}', [StartupController::class, 'deleteIdea']);


Route::post('/check-and-store-profile', [UserController::class, 'checkAndStoreProfile'])->name('checkAndStoreProfile');
Route::get('/profile/details', [UserController::class, 'showProfileDetails'])->name('user.profile.details');




Route::get('/profile/{company_name}', [StartupController::class, 'profilecompany']);