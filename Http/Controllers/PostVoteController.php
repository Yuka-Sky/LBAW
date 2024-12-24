<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostVote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PostVoteController extends Controller
{
    public function toggleVote(Request $request){
        $validated = $request->validate([
            'id_post' => 'required|exists:post,id', 
            'vote_type' => 'required|in:upvote,downvote', 
        ]);
        
        $userId = auth()->id();
        $post = Post::find($validated['id_post']);

        if ($userId === $post->user->id) {
            return response()->json(['success' => false, 'message' => 'Não podes votar na tua própria notícia.']);
        }

        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Precisas estar autenticado para votar.']);
        }

        $isUpvote = $validated['vote_type'] === 'upvote';

        $existingVote = DB::table('post_vote')
            ->where('id_user', $userId)
            ->where('id_post', $validated['id_post'])
            ->first();

        if ($existingVote) {
            if (($existingVote->upvote_bool && $isUpvote) || (!$existingVote->upvote_bool && !$isUpvote)) {
                DB::table('post_vote')
                    ->where('id_user', $userId)
                    ->where('id_post', $validated['id_post'])
                    ->delete();
                    $upvoted = false;
                    $downvoted = false;
            } else {
                DB::table('post_vote')
                    ->where('id_user', $userId)
                    ->where('id_post', $validated['id_post'])
                    ->update(['upvote_bool' => $isUpvote]);
                    $upvoted = $isUpvote;
                    $downvoted = !$isUpvote; 
            }
        } 
        else {
            DB::table('post_vote')->insert([
                'id_user' => $userId,
                'id_post' => $validated['id_post'],
                'upvote_bool' => $isUpvote,
            ]);
            $upvoted = $isUpvote;
            $downvoted = !$isUpvote; 
        }

        $upvoteCount = DB::table('post_vote')->where('id_post', $validated['id_post'])->where('upvote_bool', true)->count();
        $downvoteCount = DB::table('post_vote')->where('id_post', $validated['id_post'])->where('upvote_bool', false)->count();

        return response()->json([
            'success' => true,
            'upvoted' => $upvoted,
            'downvoted' => $downvoted,
            'upvote_count' => $upvoteCount,
            'downvote_count' => $downvoteCount,
        ]);
    }
}