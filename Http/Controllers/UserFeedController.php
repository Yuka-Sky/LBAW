<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserFeedController extends Controller
{
    public function showFeed($userId)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Precisas estar autenticado para aceder a esta página.');
        }
        
        $user = User::find($userId);
        if (!$user){ abort(404);}
        
        $posts = Post::where('id_user', $user->id)->orderBy('date', 'desc')->get();

        return view('pages.user-feed', compact('user', 'posts'));
    }
}
