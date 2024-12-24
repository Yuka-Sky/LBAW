

<div class="container">
    <h1>Resultados de pesquisa</h1>
    @if(isset($error))
        <p class="error-message">{{ $error }}</p>
    @endif
    @if($posts->isEmpty())
        <p>Nenhuma notícia encontrada!</p>
    @else
        <div class="posts">
        @include('partials.posts', ['posts' => $posts])
        <hr> <!-- Separator between posts -->
        </div>
    @endif
        
</div>
