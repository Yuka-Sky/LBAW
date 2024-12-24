@extends('layouts.app')

@section('content')

    <div class="container post-page-all">
        <h1>Criar Notícia</h1>
        <form class="form" id= "postForm" action="{{ route('post-store') }}" method="POST">
            @csrf
            <!-- Title input -->
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}"  placeholder="Título da notícia" required>
                <p id="charCount">Restam 100 caracteres.</p>
            </div>

            <!-- Subtitle input -->
            <div class="form-group">
                <label for="subtitle">Subtítulo (opcional)</label>
                <input type="text" id="subtitle" name="subtitle" class="form-control" value="{{ old('subtitle') }}" placeholder="Subtítulo da notícia">
                <p id="charCountSub">Restam 100 caracteres.</p>
            </div>

            <!-- Content input -->
            <div class="form-group">
                <label for="post-content">Conteúdo</label>
                <textarea id="post-content" name="content" class="form-control" rows="5" placeholder="Corpo da notícia" required>{{ old('content') }}</textarea>
                <p id="charCountCont">Restam 2000 caracteres.</p>
            </div>

            <!-- Tags selection -->
            <div class="form-group">
                <label for="tags_select">Tags</label>
                <fieldset id="tags_select">
                    <legend>Seleciona Tags</legend>
                    @foreach ($tags as $tag)
                        <label class="tag-label">
                            <input type="checkbox" name="tags[]" class="tag-checkbox" value="{{ $tag->id }}" 
                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                <span class="tag-name-post">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </fieldset>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Criar Notícia</button>
            <!-- Cancel button -->
            <button type="button" class="btn btn-secondary cancel-btn" data-cancel-url="{{ url('/posts') }}">Cancelar</button>

        </form>
    </div>
    
@endsection
