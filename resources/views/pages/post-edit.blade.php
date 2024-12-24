@extends('layouts.app')

@section('content')

    <div class="container post-page-all">
        <h1>Edite a sua notícia!</h1>
        <form class="form" action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Title Field -->
            <div class="form-group">
                <label for="title">Título</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="title" 
                    name="title" 
                    value="{{ $post->title }}" 
                    placeholder="Novo título da notícia"
                    required>
                <p id="charCount">Restam 100 caracteres.</p>
            </div>

            <!-- Subtitle Field -->
            <div class="form-group">
                <label for="subtitle">Subtítulo (opcional)</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="subtitle" 
                    name="subtitle" 
                    placeholder="Novo subtítulo da notícia"
                    value="{{ $post->subtitle}}">
                <p id="charCountSub">Restam 100 caracteres.</p>
            </div>

            <!-- Content Field -->
            <div class="form-group">
                <label for="post-content">Conteúdo</label>
                <textarea 
                    class="form-control" 
                    id="post-content" 
                    name="content" 
                    rows="5" 
                    placeholder="Novo conteúdo da notícia"
                    required>{{$post->content}}</textarea>
                <p id="charCountCont">Restam 2000 caracteres.</p>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Editar Notícia</button>
            <!-- Cancel button -->
            <button type="button" class="btn btn-secondary cancel-btn" data-cancel-url="{{ url()->previous() }}">Cancelar</button>
        </form>
    </div>

@endsection
