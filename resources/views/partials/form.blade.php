<form class="content" method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="form-group">
        <label for="name">Nome</label>
        <input id="name" type="text" name="name" placeholder="Introduzir nome" required>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" placeholder="Introduzir email" required>
    </div>
    <button type="submit">Enviar</button>
</form>
