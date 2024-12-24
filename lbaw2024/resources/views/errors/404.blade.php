<!-- resources/views/errors/404.blade.php -->
@extends('layouts.app')

@section('title', '404 - Page Not Found')

@section('content')
<div class="text-center mt-5">
    <br>
    <h1 class="display-4 text-danger">404</h1>
    <br>
    <h2 class="mb-4">Ooops, sinto muito! Página não encontrada</h2>
    <p class="lead">A página que estás à procura não existe ou foi movida. Tenta procurar por outra coisa ou navega utilizando o menu acima.</p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Voltar ao feed</a>
</div>
@endsection
