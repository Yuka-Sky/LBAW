<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PostVoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentVoteController;
use App\Http\Controllers\UserFeedController;
use App\Http\Controllers\UserController;        
use App\Http\Controllers\FollowController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TagFollowController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BanController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PasswordResetController;

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

// Home
Route::redirect('/', '/posts')->name('posts');

Route::get('/user/{id}', [UserController::class, 'show'])->name('user.profile');
Route::put('/user/{id}/anonymize', [UserController::class, 'anonymize'])->name('user.anonymize');

Route::get('/user/{id}/edit', function ($id) {
    if (Auth::id() !== (int) $id) { abort(403);}
    $user = App\Models\User::find($id);
    if (!$user) { abort(404);}
    return view('pages.edit-profile', ['user' => $user]);
})->name('user.edit');

Route::put('/user/{id}', function (Request $request, $id) {
    if (Auth::id() !== (int) $id) { abort(403);}
    $user = App\Models\User::find($id);

    if (!$user) {
        abort(404);
    }
    if ($request['name'] === 'Anonymous') {
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('name');
    }

    $validatedData = $request->validate([
        'name' => 'required|string|max:50|min:3',
        'email' => 'required|email|max:100|unique:users,email,' . $user->id,
    ]);
    $user->update($validatedData);
    return redirect()->route('user.profile', ['id' => $user->id])
                     ->with('success', 'Perfil atualizado com sucesso!');
})->name('user.update');


// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// Feed
Route::controller(FeedController::class)->group(function(){
    Route::get('/posts', [FeedController::class, 'index'])->name('feed.main');
    Route::get('/load-more-posts', [FeedController::class, 'loadMorePosts'])->name('posts.load_more');

});

Route::controller(UserFeedController::class)->group(function(){
    Route::get('/user/{id}/feed', [UserFeedController::class, 'showFeed'])->where('id', '^[0-9]+$')->name('user.feed');

});

// Post
Route::controller(PostController::class)->group(function () {
    Route::get('/posts/create', [PostController::class, 'create']); 
    Route::post('/posts', [PostController::class, 'store'])->name('post-store');
    Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');
    Route::get('/posts/{id}', 'show')->where('id', '^[0-9]+$')->name('posts.show');
    Route::delete('/posts/{id}/delete', [PostController::class, 'destroy'])->where('id', '^[0-9]+$')->name('posts.destroy');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->where('id', '^[0-9]+$')->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->where('id', '^[0-9]+$')->name('posts.update');
    Route::get('/posts-following', [PostController::class, 'getFollowedPosts'])->name('posts.followed');
});

// Comment
Route::controller(CommentController::class)->group(function () {
    Route::get('/comments/{commentId}', [CommentController:: class, 'show'])->where('commentId', '^[0-9]+$')->name('comments.show'); // View
    Route::get('/posts/{postId}/comments', [CommentController:: class, 'create'])->where('postId', '^[0-9]+$')->name('comments.create'); //Create - GET
    Route::post('/posts/{postId}/comments', [CommentController:: class, 'store'])->where('postId', '^[0-9]+$')->name('comments.store'); //create - Post
    Route::get('/comments/{commentId}/edit', [CommentController:: class, 'edit'])->where('commentId', '^[0-9]+$')->name('comments.edit'); // Edit - GET
    Route::put('/comments/{commentId}', [CommentController:: class, 'update'])->where('commentId', '^[0-9]+$')->name('comments.update'); // Edit - PUT
    Route::delete('/comments/{commentId}/delete', [CommentController:: class, 'destroy'])->where('commentId', '^[0-9]+$')->name('comments.destroy'); // Delete
});

// Vote
Route::post('/posts/vote', [PostVoteController::class, 'toggleVote'])->name('post.vote');
Route::post('/comments/vote', [CommentVoteController::class, 'toggleVoteComment'])->name('comment.vote');

// Static Pages
Route::view('/about-us', 'pages.about')->name('about');
Route::view('/contacts', 'pages.contacts')->name('contacts');
Route::view('/features', 'pages.features')->name('features');

//Follows
Route::post('/follows', [FollowController::class, 'store'])->name('follows.store');
Route::delete('/follows/{userId}', [FollowController::class, 'destroy'])->name('follows.destroy');

//TagFollows
Route::post('/tagfollows', [TagFollowController::class, 'store'])->name('tagfollows.store');
Route::delete('/tagfollows/{tagId}', [TagFollowController::class, 'destroy'])->name('tagfollows.destroy');

// Notificações
Route::get('/notifications', [NotificationController::class, 'show'])->name('notifications');

// Recover Password Mail
Route::post('/recover-password/send', [MailController::class, 'send'])->name('password.email');
Route::get('/recover-password', function () {
    return view('pages.recover-passw');
})->name('recover-password');

// Route to redefine password
Route::post('/password/update', [PasswordResetController::class, 'updatePassword'])->name('password.update');
Route::get('/redefine-password', function () {
    return view('pages.redefine-passw');
})->name('redefine-password');


// ------------------------------------- Technical Page Routes -----------------------------------------
// Access Technical Page
Route::get('/user/{id}/technical-page', function () {
    $users = App\Models\User::all();
    $tags = App\Models\Tag::all();
    $filteredUsers = $users->filter(function ($user) {
        return $user->name !== 'Anonymous' && $user->id !== auth()->id();
    });    

    return view('pages.technicalpage', compact('filteredUsers', 'tags'));
})->name('technical_page');

// Add and Remove Tags
Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy');

// ------------------------------------- Admin Page Routes -----------------------------------------

// Delete Account
Route::post('/user/{id}/anonByAdmin', [UserController::class, 'anonByAdmin'])->name('user.anonByAdmin');

// Promote/Unpromote Account
Route::post('/user/{id}/toggleAdmin', [UserController::class, 'toggleAdmin'])->name('user.toggleAdmin');

// Ban Account
Route::get('/ban/{id}/create', [BanController::class, 'create'])->where('id', '^[0-9]+$')->name('ban.create');
Route::post('/ban/{id}/store', [BanController::class, 'store'])->name('ban.store');
Route::delete('ban/{ban}', [BanController::class, 'remove'])->name('ban.remove');
