@foreach ($post->comments as $comment)
    <div class="comment-item mb-2">
        <br>
        @php
            \Carbon\Carbon::setLocale('pt');
        @endphp
        <p>
            "{{ $comment->content }}"
            <br>
            @if ($comment->user->id === Auth::id())
                <small id="tu">- Tu</small>
            @else
                <small>
                    - <a href="{{ route('user.profile', ['id' => $post->user->id]) }}">{{ $post->user->name ?? 'Anonymous'}}</a>
                </small>
            @endif
            &emsp;
            <small>Data: {{ $comment->date->translatedFormat('d \d\e F \d\e Y') }}</small>
        </p>
        @if(Auth::id() === $comment->id_user)
        <div class="comment-votes mt-2" id="comment-vote-counts-{{ $comment->id }}">
            <span class="text-success upvote-count" data-comment-id="{{ $comment->id }}">Upvotes: {{ $comment->upvotes() }}</span> | 
            <span class="text-danger downvote-count" data-comment-id="{{ $comment->id }}">Downvotes: {{ $comment->downvotes() }}</span>
        </div>
        <br>
        @else
            <div class="comment-votes">
            <div class="comment-votes mt-2" id="comment-vote-counts-{{ $comment->id }}">
                <form action="{{ route('comment.vote', $comment->id) }}" method="POST" id="comment-vote-form-{{ $comment->id }}">
                    @csrf
                    <input type="hidden" name="id_comment" value="{{ $comment->id }}">
                    <input type="hidden" name="redirect_to" value="{{ url()->full() }}">
                    
                    <button type="button" 
                            class="btn comment-vote-btn upvote {{ \App\Models\CommentVote::userHasUpvoted(auth()->id(), $comment->id) ? 'on' : '' }}" 
                            data-comment-id="{{ $comment->id }}" 
                            data-vote-type="upvote">
                            <i class="bi bi-hand-thumbs-up-fill"></i>
                            </button>
                            <span class="text-success upvote-count" data-comment-id="{{ $comment->id }}">{{ $comment->upvotes() }}</span>
                    <button type="button" 
                            class="btn comment-vote-btn downvote {{ \App\Models\CommentVote::userHasDownvoted(auth()->id(), $comment->id) ? 'on' : '' }}" 
                            data-comment-id="{{ $comment->id }}" 
                            data-vote-type="downvote">
                            <i class="bi bi-hand-thumbs-down-fill"></i>
                        </button>
                        <span class="text-danger downvote-count" data-comment-id="{{ $comment->id }}">{{ $comment->downvotes() }}</span>
                </form>
                
            </div>
            </div>
            
        @endif
        @if(Auth::id() === $comment->id_user)
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
@endforeach