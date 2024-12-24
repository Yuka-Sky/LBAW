@extends('layouts.app') <!-- Assuming you have a base layout -->

@section('title', 'Post Feed') <!-- Set the page title -->

@section('content')
<div class="d-flex align-items-top gap-10 mb-3">
    
    <button id="filters-btn" class="btn btn-primary me-2 align-middle">Filtros</button>
    
    <div class="search-bar flex-grow-1">
        <input type="text" id="search-input" placeholder="Pesquisar notícias..." class="form-control align-middle">
        <small id="searchError" style="color: red; display: none;">Excedeu o tamanho máximo permitido para o campo de pesquisa</small><br>      
    </div>
</div>

<div id="filters-overlay" class="filters-overlay">
    <div id="filters-menu" class="filters-menu">    
        <div class="p-3">
        <button id="close-filters-btn" class="btn-primary mb-3">Fechar</button>
        <form action="{{ route('feed.main') }}" method="GET" id="filters-form">
            <div class="form-group">
                <h3>Tags:</h3>
                    <div id="tags" class="overflow-auto border p-3" style="max-height: 200px;">
                    @if ($tagsL->count() > 0)
                        @foreach($tagsL as $tag)
                            <div class="form-check">
                                <input type="checkbox" 
                                    name="tags[]" 
                                    value="{{ $tag->name }}" 
                                    id="tag-{{ $tag->id }}" 
                                    class="form-check-input">
                                <label class="form-check-label" for="tag-{{ $tag->id }}">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        @endforeach
                    @else
                        <p> Não existem tags para selecionar. </p>
                    @endif
                    </div>    
               
            </div>
            <div class="form-group">
                <select name="filter" id="filter-select" class="form-control">
                    <option value="" disabled selected hidden>Selecione um filtro</option>
                    <option value="populares-semana">Mais populares da semana</option>
                    <option value="mais-recentes-semana">Mais recentes da semana</option>
                    <option value="mais-populares-de-sempre">Mais populares de sempre</option>
                    <option value="mais-recentes-hoje">Mais recentes de hoje</option>
                    <option value="popular-hoje">Mais populares de hoje</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Aplicar Filtro</button>
        </form>
        </div>
    </div>
</div>

<div class="container post-feed">
    <div id="search-results" class="search-feature"></div>
    <h1>Feed de notícias</h1>
    <a class="button" href="{{ url('/posts/create') }}"> Adicionar Notícia </a>
    <!-- Check if there are posts -->
    @if ($posts->count() > 0)
        <div class="posts">
            <!-- Post Container -->
            <div id="post-container">
                @include('partials.posts', ['posts' => $posts])
            </div>
        <hr> <!-- Separator between posts -->
        </div>
        <!-- "See More Posts" Button -->
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

