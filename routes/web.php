<?php

use App\Models\Season;
use App\Models\Episode;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SeriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\ReplycommentController;
use App\Http\Middleware\EnsureAdmin;
use App\Models\Replycomment;

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

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');


// ##### Admin
// Admin Homepage
Route::get('/admin', [AdminController::class, 'index'])->middleware('auth');

// Admin films management
Route::get('/admin/films', [AdminController::class, 'films'])->middleware('auth');

// Admin users management
Route::get('/admin/users', [AdminController::class, 'users'])->middleware('auth');

// Admin comments management
Route::get('/admin/comments', [AdminController::class, 'comments'])->middleware('auth');

// Episode create
Route::get('/admin/episodes/create', [EpisodeController::class, 'create'])->middleware('auth');

// Episode edit
Route::get('/admin/episodes/edit/{episode}', [EpisodeController::class, 'edit'])->middleware('auth');

// Season create
Route::get('/admin/seasons/create', [SeasonController::class, 'create'])->middleware('auth');

// Season edit
Route::get('/admin/seasons/edit/{season}', [SeasonController::class, 'edit'])->middleware('auth');

// Seri create
Route::get('/admin/series/create', [SeriController::class, 'create'])->middleware('auth');

// Seri edit
Route::get('/admin/series/edit/{seri}', [SeriController::class, 'edit'])->middleware('auth');




// ### User
// Create user
Route::get('/users/register', [UserController::class, 'create'])->middleware('guest');

// User login
Route::get('/users/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// User logout
Route::get('/users/logout', [UserController::class, 'logout'])->middleware('auth');

// User authenticate
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// Manage user
Route::get('/users/manage/{user}', [UserController::class, 'manage'])->middleware('auth');

// Edit user
Route::get('/users/edit/{user}', [UserController::class, 'edit'])->middleware('auth');

// User history
Route::get('/users/history/{user}', [UserController::class, 'history'])->middleware('auth');

// Update user
Route::put('/users/update/{user}', [UserController::class, 'update'])->middleware('auth');

// Store user
Route::post('/users', [UserController::class, 'store']);

// Delete user
Route::delete('/users/delete/{user}', [UserController::class, 'drop'])->middleware('auth');



// ### Seasons
// Get all seasons of a seri
Route::get('/seasons/get_from_seri/{seri}', [SeasonController::class, 'get_from_seri']);

// Season insert
Route::post('/seasons/store', [SeasonController::class, 'store'])->middleware('auth');

// Update a season
Route::put('/seasons/update/{season}', [SeasonController::class , 'update'])->middleware('auth');

// Delete a season
Route::delete('/seasons/delete/{season}', [SeasonController::class , 'drop'])->middleware('auth');

// Seasons random show
Route::get('/seasons/random', [SeasonController::class, 'random']);

// Seasons single movies show
Route::get('/seasons/single', [SeasonController::class, 'single']);

// Seasons single movies show
Route::get('/seasons/series', [SeasonController::class, 'series']);

// Season info
Route::get('/seasons/{season}', [SeasonController::class, 'show']);



// ### Episodes
// Episode insert
Route::post('/episodes/store', [EpisodeController::class, 'store'])->middleware('auth');

// Update an episode
Route::put('/episodes/update/{episode}', [EpisodeController::class , 'update'])->middleware('auth');

// Delete an episode
Route::delete('/episodes/delete/{episode}', [EpisodeController::class , 'drop'])->middleware('auth');

// Get all episodes of a season
Route::get('/episodes/get_from_season/{season}', [EpisodeController::class, 'get_from_season']);

// Episodes recently update show
Route::get('/episodes/recent', [EpisodeController::class , 'recent']);

// Episode play
Route::get('/episodes/{episode}', [EpisodeController::class, 'show']);




// ### Series
// Seri insert
Route::post('/series/store', [SeriController::class, 'store'])->middleware('auth');

// Update a seri
Route::put('/series/update/{seri}', [SeriController::class, 'update'])->middleware('auth');

// Delete a seri
Route::delete('/series/delete/{seri}', [SeriController::class , 'drop'])->middleware('auth');




// ### Comments
// Show comments list
Route::get('/comments/{episode}', [CommentController::class, 'show']);

// Store comment
Route::post('/comments', [CommentController::class, 'store'])->middleware('auth');

// Delete comment
Route::delete('/comments/delete/{cmt}', [CommentController::class, 'drop'])->middleware('auth');



// ### Replycomment
// Store reply comment
Route::post('/replycomments', [ReplycommentController::class, 'store'])->middleware('auth');
// Delete comment
Route::delete('/replycomments/delete/{rcmt}', [ReplycommentController::class, 'drop'])->middleware('auth');


// Toggle Like
Route::post('/likes', [LikeController::class, 'toggle'])->middleware('auth');
