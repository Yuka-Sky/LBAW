@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container notifications">
<h1>Notificações</h1>
<p>Nesta página pode ver quem interagiu com o seu conteúdo e ser notificado quando um autor que segue publica uma notícia nova.</p>
<ul>
    @foreach ($allNotifications as $notification)
            @if ($notification instanceof App\Models\PostNotification)
                @if ($notification->type === 'Vote_on_Post' && !($notification->generatorUser->name== 'Anonymous'))
                <li><a href="{{ route('posts.show', $notification->post->id) }}">{{ $notification->generatorUser->name }} gostou da sua notícia. <span>{{ $notification->date->format('F j, Y') }}</span></a></li>
                @elseif ($notification->type === 'Comment_on_Post' && !($notification->generatorUser->name== 'Anonymous'))
                <li><a href="{{ route('posts.show', $notification->post->id) }}">{{ $notification->generatorUser->name }} comentou na sua notícia. <span>{{ $notification->date->format('F j, Y') }}</span></a></li>
                @elseif ($notification->type === 'Followed_user_posted' && !($notification->generatorUser->name== 'Anonymous'))
                <li><a href="{{ route('posts.show', $notification->post->id) }}">{{ $notification->generatorUser->name }} publicou uma notícia nova. <span>{{ $notification->date->format('F j, Y') }}</span></a></li>
                @endif
            @elseif ($notification instanceof App\Models\CommentNotification && !($notification->generatorUser->name== 'Anonymous'))
            <li><a href="{{ route('posts.show', $notification->comment->post->id) }}">{{ $notification->generatorUser->name }} gostou do seu comentário. <span>{{ $notification->date->format('F j, Y') }}</span></a></li>
            @endif
    @endforeach
</ul>
</div>
@endsection
