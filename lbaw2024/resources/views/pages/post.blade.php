@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container post-page-all">
<div class="container">
    @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ url('/') }}'">Voltar</button>&emsp;
    @if (Auth::id() === $post->id_user)
    <div class="post-author">
        <a href="{{ route('posts.edit', $post->id) }}" id="edit-post" class="button">Editar</a>
        <form class="btn" action="{{ route('posts.destroy', ['id' => $post->id]) }}" method="POST" style="vertical-align: middle; display:inline-flex; align-items: center;">
            @csrf
            @method('DELETE')
            <button type="submit" id="delete-post" class="btn btn-danger" onclick="return confirm('Tem a certeza que quer apagar esta notícia?')">Apagar</button>
        </form>
    </div>
    @endif

    <div class="post-page">
        <br>
        <h1 class="post-title">{{ $post->title }}</h1>
        <h2 class="post-subtitle">{{ $post->subtitle }}</h2>
        @php
            \Carbon\Carbon::setLocale('pt');
        @endphp
        <p class="post-meta">
            Publicado por
            @if ($post->user->name === 'Anonymous')
            <strong>{{ $post->user->name }}</strong>&emsp;
            Data: {{ $post->date->translatedFormat('d \d\e F \d\e Y') }} <!-- Format date -->
            @else
            <a href="{{ route('user.profile', ['id' => $post->user->id]) }}">
                <strong>{{ $post->user->name }}</strong></a>&emsp;
                Data: {{ $post->date->translatedFormat('d \d\e F \d\e Y') }} <!-- Format date -->
            @endif
        </p>

            <div class="post-content">
                <p>{{ $post->content }}</p>
            </div>

        <!-- Display  -->
        @if ($post->tags->isNotEmpty())
            <div class="post-tags">

                @foreach ($post->tags as $tag)
                <span class="post-tags-badge badge badge-pill">#{{ $tag->getTagName() }}</span>
                @endforeach
            </div>
        @endif
        @auth
        @if(Auth::id() === $post->id_user)
        <!-- Votes Summary -->
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
            <!-- "Add Comment" Button -->
            <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('comments.create', ['postId' => $post->id]) }}'">
                Adicionar Comentário
            </button>
        </div>
        @endif
        @endauth
    </div>
    @auth
    <div class="comments-section">
        <br>
        <h3>Comentários</h3>

                @if ($post->comments->isEmpty())
                    <p>Ainda sem comentários.</p>
                    @if(Auth::id() !== $post->id_user)
                    <p> Sê o primeiro a comentar!</p>
                    @endif
                @else
                    <div class="comment-list">
                        <div id="comments-container">
                            @include('partials.comments', ['comments' => $post->comments])
                        </div>
                    </div>
                @endif
            </div>
    </div>
    @endauth
    <br>
    <br>
</div>
</div>
@endsection
