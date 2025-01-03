<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/auth', [LoginController::class, 'auth'])->name('auth');
Route::post('login_', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('home', [HomeController::class, 'index'])->middleware(['auth'])->name('home');

Route::get('author/{userId}', [PagesController::class, 'show']);

Route::post('submitPost', [PostsController::class, 'store']);
Route::post('likePost', [PostsController::class, 'like']);
Route::get('delete/{postId}', [PostsController::class, 'destroy'])->middleware('isAuthenticPostUpdate');

Route::get('post/{category}/{postId}', [PostsController::class, 'index']);
Route::get('category/{category}', [PostsController::class, 'show']);

Route::post('submitComment', [CommentsController::class, 'store']);
Route::get('deleteComment/{commentId}', [CommentsController::class, 'destroy'])->middleware('isAuthenticCommentUpdate');
Route::get('comments/{userId}', [CommentsController::class, 'show'])->middleware('isCurrentUser');
Route::get('editComment/{commentId}', [CommentsController::class, 'edit'])->middleware('isAuthenticCommentUpdate');
Route::post('updateComment', [CommentsController::class, 'update']);


Route::prefix('panel')->middleware('myMiddleware')->group(function () {
    Route::get('posts', [PostsController::class, 'posts']);
    Route::post('approve/{id}', [PostsController::class, 'postsApprove']);
});

Route::prefix('api/v1')->group(function () {
    Route::get('getPost', [App\Http\Controllers\API\v1\PostController::class, 'getPost']);
    Route::get('getComment', [App\Http\Controllers\API\v1\PostController::class, 'getComment']);
    Route::post('storeLike', [App\Http\Controllers\API\v1\PostController::class, 'storeLike']);
    Route::post('storeComment', [App\Http\Controllers\API\v1\PostController::class, 'storeComment']);
});

require __DIR__.'/auth.php';
