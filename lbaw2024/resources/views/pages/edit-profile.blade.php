@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container">
        <h1>Editar Perfil</h1>
        <br><br>
        <form id= "editProfile" class="form" action="{{ route('user.update', ['id' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" required>
            <small id="editedNameError" style="color: red; display: none;">Username deve ter entre 3 e 50 caracteres.</small><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" required>
            <small id="editedEmailError" style="color: red; display: none;">Email não deve ter mais de 100 caracteres.</small><br>
            <button type="submit" id = "edit-profile-btn" class="a-btn">Salvar Alterações</button>
        </form>
</div>
@endsection