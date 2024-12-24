@extends('layouts.app')

@section('content')
<div class="container profile">
    <h1>LogIn</h1>
    <form class="form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Introduzir email" required autofocus>
        @if ($errors->has('email'))
            <span class="error">{!! $errors->first('email') !!}</span>
        @endif

        <label for="password" >Palavra-passe</label>
        <input id="password" type="password" name="password" placeholder="Introduzir palavra-passe" required>
        <p id="passwordError" class="error" style="color: red; display: none;">
        A palavra-passe deve ter pelo menos 8 caracteres.
        </p>
        @if ($errors->has('password'))
            <span class="error">{{ $errors->first('password') }}</span>
        @endif
        <br>
        <!-- Add Forgot Password Link -->
        <a class="forgot-password" href="{{ route('recover-password') }}">Esqueceste-te da palavra-passe?</a>  
        <br>
        <button type="submit">Login</button>
        <a class="button button-outline" href="{{ route('register') }}">Registar</a>
        
        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif
    </form>
</div>
@endsection