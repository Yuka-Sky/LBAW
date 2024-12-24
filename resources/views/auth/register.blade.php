@extends('layouts.app')

@section('content')
<div class="container profile">
    <h1>Registar</h1>
  <form class="form" method="POST" action="{{ route('register') }}" id="registrationForm">
      {{ csrf_field() }}

      <label for="name">Nome</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Introduzir nome" required autofocus>
      <small id="usernameError" style="color: red; display: none;">Username deve ter entre 3 e 50 caracteres.</small><br>
      @if ($errors->has('name'))
        <span class="error">{{ $errors->first('name') }}</span>
      @endif

      <label for="email">E-Mail</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Introduzir email" required>
      @if ($errors->has('email'))
        <span class="error">{{ $errors->first('email') }}</span>
      @endif

      <label for="password">Palavra-passe</label>
      <input id="password" type="password" name="password"  placeholder="Introduzir palavra-passe" required>
      <p id="passwordError" class="error" style="color: red; display: none;">
        A palavra-passe deve ter pelo menos 8 caracteres.
      </p>
      @if ($errors->has('password'))
        <span class="error">{{ $errors->first('password') }}</span>
      @endif

      <label for="password-confirm">Confirmação da palavra-passe</label>
      <input id="password-confirm" type="password" name="password_confirmation" placeholder="Reintroduzir palavra-passe" required>
      <p id="confirmpasswordError" class="error" style="color: red; display: none;">
        As palavras-passe devem ser iguais.
      </p>
      <br>
      <button type="submit">Registar</button>
      <a class="button button-outline" href="{{ route('login') }}">Login</a>
  </form>
</div>
@endsection