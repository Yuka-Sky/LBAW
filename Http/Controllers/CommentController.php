<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\CommentVote;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Precisas estar autenticado para ver comentários.');
        }
        $comment = Comment::find($id);
        if (!$comment) { abort(404, 'Comment not found.');}

        return view('pages.comment', ['comment' => $comment]);
    }

    public function create($postId)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Precisas estar autenticado para comentar.');
        }

        $post = Post::find($postId);
        if (!$post) { abort(404, 'Post not found.');}

        return view('pages.comment-create', ['post' => $post]);
    }

    public function store(Request $request, $postId)
    {
        $post = Post::find($postId);
        if (!$post) { abort(404, 'Post not found.');}

        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $comment = Comment::create([
            'id_user' => auth()->id(),
            'id_post' => $post->id,
            'content' => $validated['content'],
            'date' => now(),
        ]);

        return redirect()->route('posts.show', ['id' => $post->id])
            ->with('success', 'Comentário adicionado com sucesso!');
    }

    public function edit($id)
    {
        $comment = Comment::find($id);
        if (!$comment) {abort(404, 'Comment not found.');}
        if (auth()->id() !== $comment->id_user) {
            abort(401, 'Não estás autorizado a editar este comentário.');
        }

        return view('pages.comment-edit', ['comment' => $comment]);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        if (auth()->id() !== $comment->id_user) {
            abort(401, 'Não estás autorizado a atualizar este comentário.');
        }
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->content = trim($validated['content']);
        $comment->save();

        return redirect()->route('posts.show', ['id' => $comment->id_post])
            ->with('success', 'Comentário editado com sucesso.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if (auth()->id() !== $comment->id_user) {
            abort(401, 'Não estás autorizado a apagar este comentário.');
        }

        $comment->delete();

        return redirect()->route('posts.show', ['id' => $comment->id_post])
            ->with('success', 'Comentário apagado.');
    }

}
