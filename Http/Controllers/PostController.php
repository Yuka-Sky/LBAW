<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\PostTag;
use App\Http\Controllers\PostTagController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\TagFollow;

class PostController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Deves estar autenticado para criar uma notícia');
        }

        $post = new Post();
        $tags = Tag::all();

        return view('pages.post-create', ['tags' => $tags]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'subtitle' => 'nullable|string|max:100',
            'content' => 'required|string|max:2000',
            'tags' => 'required|array|min:1',
            'tag.*' => 'exists:tag,id',
        ]);

        $post = Post::create([
            'id_user' => auth()->id(),
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'content' => $validated['content'],
            'date' => now(),
        ]);
        $postTagController = new PostTagController();

        foreach ($validated['tags'] as $tagId) {
            $postTagController->store([
                'id_post' => $post->id,
                'id_tag' => $tagId,
            ]);
        }

        return redirect()->route('posts.show', ['id' => $post->id])
            ->with('success', 'Notícia criada com sucesso!');
    }

    public function show($id){
        $post = Post::with('comments.user')->find($id);
        $post = Post::find($id);
        if (!$post){ abort(404);}

        return view('pages.post', ['post' => $post]);
    }

    public function edit($id){

        $post = Post::find($id);
        if (!$post){ abort(404);}

        if (auth()->id() !== $post->id_user) { abort(401);}

        return view('pages.post-edit', compact('post'));
    }
    // Get the posts that have tags the user follows
    public function getFollowedPosts(Request $request){
        $user = $request->user();
        $followedTags = $user->tag_following()->pluck('id_tag')->toArray();

        if(!empty($followedTags)){
            $posts = Post::whereHas('tags', function ($query) use ($followedTags) {
                    $query->whereIn('id_tag', $followedTags);
                });
        }
        else{
            return view('pages.posts-following', [
                'posts' => collect(),  
                'followedTags' => [],   
                'followTagMessage' => 'Ainda não segue nenhuma tag. Explore os posts disponíveis!'
            ]);

        }
        $posts = $posts->withCount('comments')->paginate(5);
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.posts', ['posts' => $posts])->render(),
                'nextPage' => $posts->nextPageUrl(),
            ]);
        }
        return view('pages.posts-following', ['posts' => $posts, 'followedTags' => $followedTags]); 
    }

    public function update(Request $request, $id){
        $post = Post::findOrFail($id);

        if (auth()->id() !== $post->id_user) { abort(401);}

        $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string|max:2000',
            'subtitle' => 'nullable|string|max:100',
        ]);

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->subtitle = $request->input('subtitle');
        $post->save();

        return redirect()->route('posts.show', ['id' => $post->id])
            ->with('success', 'A notícia foi editada!');
    }

    public function destroy(Request $request){
        $post = Post::find($request->id);
        if (!$post) {
            return redirect()->back()->withErrors(['error' => 'Notícia não encontrada.']);
        }

        if ($post->id_user !== auth()->id()) {
            return redirect()->route('posts.show', ['id' => $post->id])
                ->withErrors(['error' => 'Apenas o autor pode apagar esta notícia.']);
        }
        
        $post->delete();
        return redirect()->route('posts', ['id' => auth()->id()])
            ->with('success', 'Notícia apagada com sucesso.');
    }

    public function search(Request $request){   
        $query = $request->input('query');
        if (strlen($query) > 200) {
            return view('pages.post-search', [
                'error' => 'A pesquisa não pode ter mais de 200 caracteres.',
                'posts' => collect(),
            ]);
        }
        $query = preg_replace('/[^\p{L}0-9\s]/u', ' ', $query);
        $query = trim($query);
        $query = preg_replace('/\s+/', ' ', trim($query));
        if ( empty($query)) {
            return view('pages.post-search', ['posts' => collect()]);
        }
        $terms = explode(' ', $query);
        $query = implode(' | ', $terms); 
        $query = $query.':*';
        $posts = Post::select('*')->whereRaw("tsvectors @@ to_tsquery('portuguese', ?)", [$query])
            ->orderByRaw("ts_rank(tsvectors, to_tsquery('portuguese', ?)) DESC", [$query])
            ->get();

        return view('pages.post-search', compact('posts'));
    }
}

