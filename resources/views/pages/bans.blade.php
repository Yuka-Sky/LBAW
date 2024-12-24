@extends('layouts.app')

@section('title', 'Página de Ban')

@section('content')
<div class="container bans-page">
<button class="btn btn-primary" onclick="location.href='{{ route('technical_page', ['id' => auth()->id()]) }}'">Voltar</button>
@if ($user->is_admin)
    <h1>Banir Administrador: {{ $user->name }}</h1>
@else
    <h1>Banir Utilizador: {{ $user->name }}</h1>
@endif
<form class="form" action="{{ route('ban.store', $user->id) }}" method="POST">
    @csrf

    <label for="reason">Motivo do Ban</label>
    <input type="text" name="reason" id="reason" placeholder="Introduz a razão do ban desta conta" required>

    <label for="permanent">Ban Permanente</label>
    <input type="checkbox" name="permanent" id="permanent" value="1" onclick="toggleEndDate(this)">

    <label for="begin_date">Data de Início:</label>
    <input type="datetime-local" name="begin_date" id="begin_date" required>

    <label for="end_date" id="end_date_label">Data de Fim:</label>
    <input type="datetime-local" name="end_date" id="end_date">

    <button type="submit" class="btn btn-danger admin-buttons">Banir</button>
</form>
</div>
<script>
    function toggleEndDate(checkbox) {
        const endDateField = document.getElementById('end_date');
        const endDateLabel = document.getElementById('end_date_label');
        if (checkbox.checked) {
            endDateField.style.display = 'none';
            endDateLabel.style.display = 'none';
            endDateField.value = '';
        } else {
            endDateField.style.display = 'block';
            endDateLabel.style.display = 'block';
        }
    }
</script>
@endsection
