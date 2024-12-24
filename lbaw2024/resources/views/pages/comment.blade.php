@extends('layouts.app')

@section('title', 'Comment Details')

@section('content')
    <div class="container comment-item">
        
        <div class="comment-content">
            <h4>"{{ $comment->content }}"</h4>
        </div>
        <p class="comment-meta">
            Publicado por <a href="{{ route('user.profile', ['id' => $comment->user->id]) }}"><strong>{{ $comment->user->name }}</strong></a>&emsp;
            Data: {{ $comment->date->format('F j, Y') }}
        </p>
        @auth
        <!-- Votes Summary -->
        <div class="comment-votes mt-2" id="comment-vote-counts-{{ $comment->id }}">
            <span class="text-success upvote-count" data-comment-id="{{ $comment->id }}">Upvotes: {{ $comment->upvotes() }}</span> | 
            <span class="text-danger downvote-count" data-comment-id="{{ $comment->id }}">Downvotes: {{ $comment->downvotes() }}</span>
        </div>
        @if(Auth::id() !== $comment->id_user)
        <div class="comment-votes">
            <form action="{{ route('comment.vote', $comment->id) }}" method="POST" id="comment-vote-form-{{ $comment->id }}">
                @csrf
                <input type="hidden" name="id_comment" value="{{ $comment->id }}">
                <input type="hidden" name="redirect_to" value="{{ url()->full() }}">
                
                <button type="button" 
                        class="btn comment-vote-btn upvote {{ \App\Models\CommentVote::userHasUpvoted(auth()->id(), $comment->id) ? 'on' : '' }}" 
                        data-comment-id="{{ $comment->id }}" 
                        data-vote-type="upvote">
                        🖒 
                </button>
                <button type="button" 
                        class="btn comment-vote-btn downvote {{ \App\Models\CommentVote::userHasDownvoted(auth()->id(), $comment->id) ? 'on' : '' }}" 
                        data-comment-id="{{ $comment->id }}" 
                        data-vote-type="downvote">
                        🖓
                </button>
            </form>
        </div>
        @endif
        @endauth
        <!-- Edit and Delete -->
        @if (Auth::id() === $comment->id_user)
            <div class="comment-actions">
                <button onclick="window.location.href='{{ route('comments.edit', ['commentId' => $comment->id]) }}'" class="btn btn-sm btn-primary">Editar</button>
                <form action="{{ route('comments.destroy', ['commentId' => $comment->id]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Queres mesmo remover este comentário?')">Apagar</button>
                </form>
            </div>
        @endif
    </div>
@endsection
