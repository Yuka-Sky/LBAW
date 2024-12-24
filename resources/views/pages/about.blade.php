@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="container static">
    <header>
        <h1>Sobre o InFEUP</h1>
    </header>

    <h2>Visão</h2>
    <p>
        O objetivo do InFEUP é oferecer à comunidade da FEUP uma forma de se manter informada sobre atualizações importantes e aceder a qualquer informação que considerem relevante por meio de notícias. 
        Ao mesmo tempo, o InFEUP proporciona um espaço para que os membros compartilhem as próprias notícias que considerem significativas, assegurando que todos estão conectados e atualizados.
    </p>

    <h2>O que Oferecemos?</h2>
    <p>
        - Uma plataforma centralizada para todas as notícias e atualizações relacionadas à FEUP.<br>
        - Ferramentas para compartilhar notícias com informações importantes.<br>
        - Uma abordagem focada na comunidade, promovendo conectividade e interação.
    </p>
        
    <h2>Porquê Escolher o InFEUP?</h2>
    <p>
        O InFEUP é projetado pela e para a comunidade da FEUP, com foco em simplicidade, confiabilidade e acessibilidade. A nossa missão é mantê-lo conectado a tudo o que importa.
    </p>

    <h2>Sobre nós</h2>
    <p>
        O InFEUP foi desenvolvido no âmbito da unidade curricular Laboratório de Bases de Dados e Aplicações Web pelo grupo 2463:<br>
        <a href="{{ route('contacts') }}">Gonçalo Moreira</a><br>
        <a href="{{ route('contacts') }}">Micaela Albino</a><br>
        <a href="{{ route('contacts') }}">Tiago Teixeira</a><br>
        <a href="{{ route('contacts') }}">Yuka Sakai</a>
            
    </p>
</div>
@endsection