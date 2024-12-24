@extends('layouts.app')

@section('title', 'Recover Password')

@section('content') 
        <div class="container">
            <h1>Recuperar palavra-passe</h1>
            <div class="recover-password-container">
                @if(session('status'))
                    @include('partials.feedback') <!-- Handles feedback after form submission -->
                @else
                    @include('partials.form') <!-- Displays the form for input -->
                @endif
            </div>
        </div>
@endsection
