@extends('layouts.app')

@section('title', 'Redefine Password')

@section('content')
    <div class="container">
        <h1>Redefinir Palavra-passe</h1>
        <div class="redefine-password-container">
            <form class="content" method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="form-group">
                    <!-- Email Field -->
                    <label for="email">E-Mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Introduzir email" required>
                    
                    <!-- Password Field -->
                    <label for="password">Palavra-passe</label>
                    <input id="password" type="password" name="password" placeholder="Introduzir palavra-passe" required>

                    <!-- Password Length Error -->
                    <p id="passwordError" class="error" style="color: red; display: none;">
                        A palavra-passe deve ter pelo menos 8 caracteres.
                    </p>

                    <!-- Confirm Password Field -->
                    <label for="password-confirm">Confirmação da Palavra-passe</label>
                    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Reintroduzir palavra-passe" required>

                    <!-- Password Confirmation Error -->
                    <p id="confirmpasswordError" class="error" style="color: red; display: none;">
                        As palavras-passe não coincidem.
                    </p>
                </div>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
@endsection
