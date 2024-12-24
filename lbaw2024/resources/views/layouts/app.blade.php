<!DOCTYPE html>
<html  lang="pt-PT">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>
    <body>
    <main>
        <nav class="navbar fixed-top navbar-expand-md navbar-dark">
        <div class="container-fluid align-items-center justify-content-between">
            <button type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" class="navbar-toggler" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active m-auto">
                        <a href="{{ route('about') }}" class="nav-link">Sobre Nós</a>
                    </li>
                    <li class="nav-item active m-auto">
                        <a href="{{ route('contacts') }}" class="nav-link">Contactos</a>
                    </li>
                    <li class="nav-item active m-auto">
                        <a href="{{ route('features') }}" class="nav-link">Serviços</a>
                    </li>
                    @if (Auth::check())
                    <li class="nav-item dropdown m-auto">
                        <a href="#" class="nav-link dropdown-toggle" id="dropdownTags" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Tags</a>
                        @php
                            $followedTags = Auth::check() ? Auth::user()->tag_following->pluck('id_tag')->toArray() : [];
                        @endphp
                        <ul class="dropdown-menu" aria-labelledby="dropdownTags">
                            @foreach ($tags as $tag)
                            <li>
                                <div class="dropdown-item">
                                    <span class="tag-name">{{ $tag->name }}</span>
                                    @if (in_array($tag->id, $followedTags))
                                        <form action="{{ route('tagfollows.destroy', $tag->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <i class="fa-solid fa-heart unfollow-tag" onclick="this.parentElement.submit();"></i>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('tagfollows.store') }}">
                                        @csrf
                                        <input type="hidden" name="id_tag" value="{{ $tag->id }}">
                                        <i class="fa-regular fa-heart follow-tag"  onclick="this.parentElement.submit();"></i>
                                        </form>
                                    @endif
                                </div>
                            
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                </ul>

            
            </div>

            <a class="navbar-brand mx-auto h1" href="{{ url('/posts') }}">In<span class="badge align-center badge-secondary">FEUP</span></a>
            <div class="d-flex justify-content-center align-items-center gap-3">
            @if (Auth::check())
            <a href="{{ route('posts.followed') }}" class="text-white mr-2 ml-5 px-3 py-1 text-decoration-none" >Interesses</a>
            <a class="text-white mr-2 ml-5 px-3 py-1 text-decoration-none" href="{{ route('notifications') }}">Notificações</a>
            <a class="text-dark mr-2 ml-5 px-3 py-1 rounded text-decoration-none" style="background-color:#f5e8da" href="{{ route('user.profile', ['id' => Auth::user()->id]) }}">{{ Auth::user()->name }}</a>
                <p class="text-white m-auto">|</p>
            <a class="text-white ml-2 mr-5 text-decoration-none" href="{{ url('/logout') }}">Logout</a>
            @else
                <a class="text-dark mr-2 ml-5 px-3 py-1 rounded text-decoration-none" style="background-color:#f5e8da" href="{{ url('/login') }}"> Login </a>
                <p class="text-white m-auto">|</p>
                <a class="text-white ml-2 mr-5 text-decoration-none" href="{{ url('/register') }}"> Registar </a>
            @endif
            </div>
        </div>
        </nav>

        <section id="content">
            <div class="container">
                @yield('content')
            </div>
        </section>
        <br>
        <br>
        <!-- Footer -->
        <footer class="fixed-footer">
            <div class="footer-content">
                <span class="footer-left">©InFeup</span>
                <span class="footer-right">Um sistema feito pelos estudantes da FEUP</span>
            </div>
        </footer>
    </main>
    
</body>
</html>