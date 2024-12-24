@extends('layouts.app')

@section('title', 'Profile')

@section('content')<button type="button" class="btn btn-primary" onclick="window.location.href='{{ url('/') }}'">Voltar</button>&emsp;
<div class="container profile">
    
    <section class="user-info">
        <div class="name-follow">
            <h1 class="username">{{ $user->name }}</h1>
            @if(Auth::check() && Auth::id() !== $user->id)
            @if($isFollowing)
                <form action="{{ route('follows.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="ml-1 m-auto" type="submit">Deixar de Seguir</button>
                </form>
            @else
                <form method="POST" action="{{ route('follows.store') }}">
                    @csrf
                    <input type="hidden" name="id_user_followed" value="{{ $user->id }}">
                    <button class="ml-1 m-auto" type="submit">Seguir</button>
                </form>
            @endif
            @else
            <p class="reputation">Reputação: {{ $user->reputation }}</p>
            @endif
        </div>
        
        <p> {{ $user->email }}</p>
        @if(Auth::check() && Auth::id() !== $user->id)
        <p class="reputation">Reputação: {{ $user->reputation }}</p>
        @endif
        
        @if (Auth::check() && Auth::id() === $user->id)
        <br>
        <a href="{{ route('user.feed', $user->id) }}" class="posts-user">Ver as suas notícias</a>
        <br>
        <br>
        <div class="account-edit">
            @if (Auth::check() && Auth::user()->is_admin)
                <a href="{{ route('technical_page', ['id' => Auth::user()->id]) }}" class="button">Acesso Técnico</a>
            @endif
            <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="button">Editar Perfil</a>
            <form id="anonymize-account-form" action="{{ route('user.anonymize', $user->id) }}" method="POST" style="display: none;">
                @csrf
                @method('PUT')
            </form>
            <button id="anonymize-account-button" class="btn btn-danger">Apagar Conta</button>    
        </div>
        <div class="profile-follow">
            <div class="follow-users">
            @if ($user->following->isEmpty())
                <h2>Ainda não segue ninguém</h2>
            @else
                <h2>Utilizadores que segue:</h2>
                <ul>
                    @foreach ($user->following as $follow)
                    @if(!($follow->followedUser->name === 'Anonymous'))
                        <li><a  href="{{ route('user.profile', ['id' => $follow->followedUser]) }}">{{ $follow->followedUser->name }}</a></li>
                    @endif
                    @endforeach
                </ul>
            @endif
            </div>
            <div class="follow-tags">
            @if ($user->tag_following->isEmpty())
                <h2>Ainda não segue nenhuma tag</h2>
            @else
                <h2>Tags que segues:</h2>
                <ul>
                    @foreach ($user->tag_following as $tagfollow)
                        <li>{{ $tagfollow->tag->name }}</li>
                    @endforeach
                </ul>
            @endif
            </div>
        </div>
        @else
            <a href="{{ route('user.feed', $user->id) }}" class="posts-user">Ver as notícias de <strong> {{ $user->name }} </strong></a>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <br>
        <br>
</section>
</div>
@endsection