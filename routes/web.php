<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserManagementController;


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
    return view('landing');
});

Auth::routes();

// Route::group(['middleware' => ['web','auth']], function ());

Route::get('/', [PostController::class, 'landingPage'])->name('landing.page');

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.myPosts');

    Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/manage-users', [UserManagementController::class, 'index'])->name('admin.manageUsers');
    Route::put('/admin/change-role/{id}', [UserManagementController::class, 'changeRole'])->name('admin.changeRole');
    Route::get('/admin/pending_posts', [AdminController::class, 'pendingPosts'])->name('admin.pending_posts');
    Route::post('/approve-post/{id}', [AdminController::class, 'approvePost'])->name('admin.approvePost');
    Route::post('/reject-post/{id}', [AdminController::class, 'rejectPost'])->name('admin.rejectPost');
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    });
});


Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');


Route::resource('posts', PostController::class);
