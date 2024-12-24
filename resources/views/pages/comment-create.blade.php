@extends('layouts.app')

@section('title', 'Criar Comentário')

@section('content')

    <div class="container post-page-all">
        <h1>Adicionar Comentário</h1>
        <form class="form" action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="content">Conteúdo</label>
                <textarea class="form-control" id="comment-content" name="content" rows="5" placeholder= "Introduzir aqui um comentário" required></textarea>
                <p id="charCountCom">Restam 1000 caracteres.</p>
            </div>
            <button type="submit" class="btn btn-primary">Publicar</button>
        </form>
    </div>
    
@endsection
