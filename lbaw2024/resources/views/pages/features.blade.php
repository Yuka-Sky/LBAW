@extends('layouts.app')

@section('title', 'Funcionalidades')

@section('content')
<div class="container static">
    <header>
        <h1>Serviços InFEUP</h1>
    </header>

    <section>
        <p>Se é visitante, confira aqui o que pode fazer neste site!!</p>
        <ul>
            <li><a href="{{ route('posts') }}">Navegar pelo feed através da página inicial</a></li>
            <li>Ver os detalhes de uma notícia clicando no título da notícia</li>
            <li>Aceder à página <strong><a href="{{ route('about') }}">Sobre Nós</a></strong> e as informações de <strong><a href="{{ route('contacts') }}">Contactos</a></strong> da equipa InFEUP.</li>
            <li>Pesquisar por notícias usando Full Text Search</li>
        </ul>
    </section>
    
    <section>
        <p>Se já criaste conta na InFEUP, tens acesso aos seguintes benefícios!!</p>
        <ul>
            <li>Criar uma notícia através do botão na página inicial</li>
            <li>Editar ou remover uma notícia própria</li>
            <li>Editar as informações do perfil</li>
            <li>Adicionar um comentário em uma notícia</li>
            <li>Editar ou remover um comentário próprio</li>
            <li>Seguir outros autores</li>
            <li>Aceder à página de notificações onde podes ver quem interagiu com o teu conteúdo e ser notificado quando alguém que segues publicou</li>
            <li>Adicionar um like ou dislike a notícias ou comentários para demonstrares a tua opinião</li>
            <li>Seguir Tags que representem os tópicos que mais te interessam</li>
            <li>Aceder à página de Notícias de Interesse onde podes ver as notícias com as tags que segues</li>
        </ul>
    </section>
</div>
@endsection