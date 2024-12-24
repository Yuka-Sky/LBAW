<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentVote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CommentVoteController extends Controller
{
    public function toggleVoteComment(Request $request){
        $validated = $request->validate([
            'id_comment' => 'required|exists:comment,id', 
            'vote_type' => 'required|in:upvote,downvote', 
        ]);

        $userId = auth()->id();
        $comment = Comment::find($validated['id_comment']);

        if ($userId === $comment->user->id) {
            return response()->json(['success' => false, 'message' => 'Não podes votar no teu próprio comentário.']);
        }

        
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Precisas estar autenticado para votar.']);
        }

        $isUpvote = $validated['vote_type'] === 'upvote';

        $existingVote = DB::table('comment_vote')
            ->where('id_user', $userId)
            ->where('id_comment', $validated['id_comment'])
            ->first();

        if ($existingVote) {
            if (($existingVote->upvote_bool && $isUpvote) || (!$existingVote->upvote_bool && !$isUpvote)) {
                DB::table('comment_vote')
                    ->where('id_user', $userId)
                    ->where('id_comment', $validated['id_comment'])
                    ->delete();
                    $upvoted = false;
                    $downvoted = false;
            } else {
                DB::table('comment_vote')
                    ->where('id_user', $userId)
                    ->where('id_comment', $validated['id_comment'])
                    ->update(['upvote_bool' => $isUpvote]);
                    $upvoted = $isUpvote;
                    $downvoted = !$isUpvote; 
            }
        } 
        else {
            DB::table('comment_vote')->insert([
                'id_user' => $userId,
                'id_comment' => $validated['id_comment'],
                'upvote_bool' => $isUpvote,
            ]);
            $upvoted = $isUpvote;
            $downvoted = !$isUpvote; 
        }

        $upvoteCount = DB::table('comment_vote')->where('id_comment', $validated['id_comment'])->where('upvote_bool', true)->count();
        $downvoteCount = DB::table('comment_vote')->where('id_comment', $validated['id_comment'])->where('upvote_bool', false)->count();

        return response()->json([
            'success' => true,
            'upvoted' => $upvoted,
            'downvoted' => $downvoted,
            'upvote_count' => $upvoteCount,
            'downvote_count' => $downvoteCount,
        ]);
    }
}
