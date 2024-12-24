@extends('layouts.app')

@section('title', 'Technical Page')

@section('content')
<div class="container technical">
    <button class="btn btn-primary" onclick="window.location.href='{{ route('user.profile', ['id' => Auth::user()->id]) }}'">Voltar</button>
    <h2>Página Técnica</h2>
    <small><i>Esta página é apenas acessível por administradores.</i></small>
    <br>
    <br>
    <div class="admin-container">
        <div class="row">
            <div class="col-md-6">
                <h3>Utilizadores:</h3>
                <ul>
                    @forelse ($filteredUsers as $user)
                        @if ($user->name !== 'Anonymous' && $user->id !== auth()->id())
                        <li>
                            {{ $user->name }} <i>({{ $user->email }})</i>
                            <br>
                            <div id="user_buttons">
                                <button 
                                    class="btn btn-danger promote-button admin-buttons" 
                                    data-user-id="{{ $user->id }}" 
                                    data-is-admin="{{ $user->is_admin }}">
                                    {{ $user->is_admin ? 'Despromover' : 'Promover' }}
                                </button>

                                <form id="anonymize-account-form-{{ $user->id }}" 
                                    action="{{ route('user.anonByAdmin', $user->id) }}" 
                                    method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button 
                                        type="button"
                                        class="btn btn-danger anonymize-button admin-buttons"
                                        data-user-id="{{ $user->id }}">
                                            Apagar
                                    </button> 
                                </form>
                                
                                @php
                                    $ban = \App\Models\Ban::where('id_user', $user->id)->first(); // Check if user is banned
                                @endphp
                                
                                @if ($ban)
                                    <form action="{{ route('ban.remove', $ban->id) }}" 
                                          method="POST" 
                                          class="ban-form" 
                                          data-user-id="{{ $user->id }}" 
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger admin-buttons">
                                            Banido
                                        </button>
                                    </form>
                                @else
                                    <button 
                                        class="btn btn-danger admin-buttons" 
                                        onclick="location.href='{{ route('ban.create', $user->id) }}'">
                                        Banir
                                    </button>
                                @endif
                            </div>
                        </li>
                        @endif
                    @empty
                        <i><small>Não existem outros utilizadores.</small></i>
                    @endforelse
                </ul>
            </div>
            
            <div class="col-md-6">
                <h3>Tags:</h3>
                <button id="add-tag-button" class="btn btn-primary">Adicionar Tag</button>
                <input type="text" id="tag-input" placeholder="Digite a tag e clique em Enter para adicionar" style="display:none;">
                <ul id="tag-list">
                    @forelse ($tags as $tag)
                        <li id="tag-{{ $tag->id }}" class="tag-item">
                            #{{ $tag->name }}
                            <button class="btn btn-danger delete-tag-button" data-tag-id="{{ $tag->id }}">X</button>
                        </li>
                    @empty
                        <i><small>Não existem tags.</small></i>
                    @endforelse
                </ul>
            </div>
        </div>
        <br>
        <br>
    </div>
</div>
@endsection
