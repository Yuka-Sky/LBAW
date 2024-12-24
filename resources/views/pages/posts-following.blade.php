@extends('layouts.app') 

@section('title', 'Posts with Followed tags') 

@section('content')

<div class="container post-feed">

<h1>Notícias de interesse</h1>
<p>Nesta página pode ver as notícias acerca das tags que está a seguir.</p>
    @if (isset($followTagMessage))
        <div class="alert alert-warning">
            {{ $followTagMessage }}
        </div>
    @endif
    


    @if ($posts->count() > 0)
        <div class="posts">
            <div id="post-container">
                @include('partials.posts', ['posts' => $posts])
            </div>
        <hr>
        </div>

        @if ($posts->hasMorePages())
            <button id="load-more" class="btn btn-primary" data-next-page="{{ $posts->nextPageUrl() }}">
                Ver Mais Notícias
            </button>
        @endif

    @else
        <p>Nenhuma notícia encontrada.</p>
    @endif
    <br>
    <br>
</div>
@endsection
