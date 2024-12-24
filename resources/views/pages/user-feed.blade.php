@extends('layouts.app')

@section('title', 'User Feed') <!-- Set the page title -->

@section('content')

    <div class="container">
        <h1> Notícias de {{ $user->name }}</h1>
        @if ($posts->isEmpty())
            <p>Sem notícias disponívels.</p>
        @else
        <div class="posts">
                @include('partials.posts', ['posts' => $posts])
        @endif
    </div>

@endsection
