@extends('layouts.app')

@section('title', 'Edit Comment')

@section('content')

    <div class="container post-page-all">
        <h1>Edite o seu comentário</h1>

        <form class="form" id="edit-comment-form" action="{{ route('comments.update', $comment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="content">Conteúdo</label>
                <textarea 
                    class="form-control" id="comment-content" name="content" rows="5" placeholder= "Introduzir aqui um comentário" required>{{ str_replace(["\r", "\n"], '', trim($comment->content ?? '')) }}
                </textarea>
                <p id="charCountCom">Restam 1000 caracteres.</p>
            </div>
            <button type="button" class="btn btn-primary" id="confirm-edit-button">Editar</button>
            <button type="button" class="btn btn-secondary" id="cancel-button" onclick="window.location.href='{{ url()->previous() }}'">Cancelar</button>
        </form>
    </div>

    <script>
        const maxChars = 1000; // Maximum character limit
        function updateCharCount() {
            const content = document.getElementById('comment-content');
            content.value = content.value.trim();
            const charCount = document.getElementById('charCountCom');
            const remaining = maxChars - content.value.length;
            charCount.textContent = `Restam ${remaining} caracteres.`;
        }
        // Initialize the count when the page loads (useful for pre-filled content)
        document.addEventListener('DOMContentLoaded', () => {
            updateCharCount();
        });
        document.getElementById('confirm-edit-button').addEventListener('click', function() {
            if (confirm('Confirmar a edição?')) {
                document.getElementById('edit-comment-form').submit();
            }
        });
    </script>

@endsection
