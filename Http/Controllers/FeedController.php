<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'tags' => 'nullable|array',
            'tags.*' => 'string|exists:tag,name',
            'filter' => 'nullable|string|in:popular-hoje,mais-recentes-hoje,mais-populares-de-sempre,mais-recentes-semana,populares-semana',
        ]);
        $tagsArray = $validated['tags'] ?? [];
        $filter = $validated['filter'] ?? '';
        $limit = 3;

        $postsQuery = Post::query();

        if(!empty($tagsArray))
        {

            
            $postsQuery->join('post_tag', 'post.id', '=', 'post_tag.id_post')
            ->join('tag', 'post_tag.id_tag', '=', 'tag.id')
            ->whereIn('tag.name', $tagsArray)
            ->groupBy('post.id');

        }
        
        if ($filter) {
            switch ($filter) {
                case 'popular-hoje':
                    $postsQuery->whereDate('date', today());
                    $postsQuery->LeftJoin('post_vote', 'post.id', '=', 'post_vote.id_post')
                    ->select('post.*',
                    DB::raw('COUNT(CASE WHEN post_vote.upvote_bool = true THEN 1 END) as upvotes_count'))
                    ->groupBy('post.id') 
                    ->orderByDesc('upvotes_count')
                    ->orderByDesc(DB::raw('COUNT(CASE WHEN post_vote.upvote_bool = true THEN 1 END) - COUNT(CASE WHEN post_vote.upvote_bool = false THEN 1 END)'));  // Order by the difference (downvotes_count)
                    break;

                case 'mais-recentes-hoje':
                    $postsQuery->whereDate('date', today())
                    ->orderByDesc('date');
                    break;
                
                case 'mais-populares-de-sempre':
                    $postsQuery->LeftJoin('post_vote', 'post.id', '=', 'post_vote.id_post')
                    ->select('post.*',
                    DB::raw('COUNT(CASE WHEN post_vote.upvote_bool = true THEN 1 END) as upvotes_count'))
                    ->groupBy('post.id')
                    ->orderByDesc('upvotes_count')
                    ->orderByDesc(DB::raw('COUNT(CASE WHEN post_vote.upvote_bool = true THEN 1 END) - COUNT(CASE WHEN post_vote.upvote_bool = false THEN 1 END)'));
                    break;
                
                case 'mais-recentes-semana':
                    $postsQuery->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
                    $postsQuery->orderByDesc('date');
                    break;

                case 'populares-semana':
                    $postsQuery->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
                    $postsQuery->LeftJoin('post_vote', 'post.id', '=', 'post_vote.id_post')
                    ->select('post.*',
                    DB::raw('COUNT(CASE WHEN post_vote.upvote_bool = true THEN 1 END) as upvotes_count'))
                    ->groupBy('post.id')
                    ->orderByDesc('upvotes_count')
                    ->orderByDesc(DB::raw('COUNT(CASE WHEN post_vote.upvote_bool = true THEN 1 END) - COUNT(CASE WHEN post_vote.upvote_bool = false THEN 1 END)'));  // Order by the difference (downvotes_count)
                    break;

            }
        }
        // If no filter is selected, posts are shown by most recent
        else{
            $postsQuery->orderByDesc('date');
        }
        $posts = $postsQuery->withCount('comments')->paginate($limit);
        $posts->appends($request->only('tags', 'filter'));
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.posts', ['posts' => $posts])->render(),
                'nextPage' => $posts->nextPageUrl(),
            ]);
        }

        $tagsList = Tag::all();
        return view('pages.feed', ['posts' => $posts, 'tagsL' => $tagsList]);
       
    }
}
