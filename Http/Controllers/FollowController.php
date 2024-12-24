<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    public function store(Request $request)
    {
        $idUserFollower = auth()->id();
        $idUserFollowed = $request->input('id_user_followed');
        $exists = Follow::where('id_user_follower', $idUserFollower)
                        ->where('id_user_followed', $idUserFollowed)
                        ->exists();

        if ($exists) {
            return back()->with('message', 'Tu já segues este utilizador.');
        }

        Follow::insert([
            'id_user_follower' => $idUserFollower,
            'id_user_followed' => $idUserFollowed,
        ]);

        return back()->with('message', 'Começaste a seguir este utilizador!');
    }

    public function destroy($userId)
    {
        DB::table('follows')
        ->where('id_user_follower', auth()->id())
        ->where('id_user_followed', $userId)
        ->delete();

        return back()->with('message', 'Deixaste de seguir este utilizador.');
    }

    public function index($id_user_follower)
    {
        $follows = Follow::where('id_user_follower', $id_user_follower)
                         ->with('followedUser')
                         ->get();

        return response()->json($follows);
    }
}