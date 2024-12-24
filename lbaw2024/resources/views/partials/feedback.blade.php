<section class="content">
    <h3>{{ session('status') }}</h3>
    <h4>{{ session('message') }}</h4>
    @if(session('details'))
        <ul>
            @foreach(session('details') as $detail)
                <h5>{{ $detail }}</h5>
            @endforeach
        </ul>
    @endif
    <button onclick="reloadPage()">
        Tentar Novamente
    </button>
</section>