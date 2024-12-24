@foreach ($posts as $post)
    <div class="post mb-4">
        <br>
    <a href="{{ route('posts.show', $post->id) }}"><h2 class="post-title">{{ $post->title }}</h2>
        <h4 class="post-subtitle">{{ $post->subtitle }}</h4>
        
        <div class="post-content">
            <p>{{ Str::limit($post->content, 150) }}</p> 
        </div>
        </a>
        <small>
            @php
                \Carbon\Carbon::setLocale('pt');
            @endphp
            <p class="post-meta">
                Publicado por
            @if ($post->user->name === 'Anonymous')
            <strong>{{ $post->user->name }}</strong>&emsp;
            Data: {{ $post->date->translatedFormat('d \d\e F \d\e Y') }}
            @else
            <a href="{{ route('user.profile', ['id' => $post->user->id]) }}">
                <strong>{{ $post->user->name }}</strong></a>&emsp;
                Data: {{ $post->date->translatedFormat('d \d\e F \d\e Y') }}
            @endif
            </p>
        </small>


        @if ($post->tags->isNotEmpty())
            <div class="post-tags">
                @foreach ($post->tags as $tag)
                    <span class="post-tags-badge badge badge-pill">#{{ $tag->getTagName() }}</span>
                @endforeach
            </div>
        @endif

        @auth
        @if(Auth::id() === $post->id_user)
        <div class="post-votes mt-2" id="vote-counts-{{ $post->id }}">
            <span class="text-success upvote-count" data-post-id="{{ $post->id }}">Upvotes: {{ $post->upvotes() }}</span> | 
            <span class="text-danger downvote-count" data-post-id="{{ $post->id }}">Downvotes: {{ $post->downvotes() }}</span>
        </div>
        @else
        <div class="post-votes">
        <div class="post-votes mt-2" id="vote-counts-{{ $post->id }}">
            <form action="{{ route('post.vote', $post->id) }}" method="POST" id="vote-form-{{ $post->id }}">
                @csrf
                <input type="hidden" name="id_post" value="{{ $post->id }}">
                <input type="hidden" name="redirect_to" value="{{ url()->full() }}">
                <button type="button" 
                        class="btn vote-btn upvote {{ \App\Models\PostVote::userHasUpvoted(auth()->id(), $post->id) ? 'on' : '' }}" 
                        data-post-id="{{ $post->id }}" 
                        data-vote-type="upvote"
                        style="padding: 0; width: auto; height: auto; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="bi bi-hand-thumbs-up-fill"></i>
                </button>
                <span class="text-success upvote-count" data-post-id="{{ $post->id }}">{{ $post->upvotes() }}</span>
                <button type="button" 
                        class="btn vote-btn downvote {{ \App\Models\PostVote::userHasDownvoted(auth()->id(), $post->id) ? 'on' : '' }}" 
                        data-post-id="{{ $post->id }}" 
                        data-vote-type="downvote">
                        <i class="bi bi-hand-thumbs-down-fill"></i>
                </button>
                <span class="text-danger downvote-count" data-post-id="{{ $post->id }}">{{ $post->downvotes() }}</span>
            </form>
            </div>
        </div>
        @endif
        <a href="{{ route('posts.show', $post->id) }}" class="post-comments">
            Ver {{ $post->comments_count }} {{ Str::plural('comentário', $post->comments_count) }}
        </a>
        @endauth
    </div>
@endforeach