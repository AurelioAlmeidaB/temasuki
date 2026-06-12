<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Restaurante Temasuki')</title>
    <link rel="stylesheet" href="{{ url('/css/styles.css') }}">
</head>
<body>

<nav class="navbar-temasuki">
    <a href="{{ url('/') }}" class="navbar-brand-wrap">
        <img src="{{ url('/img/totodile_logo.png') }}" alt="Temasuki">
        <span class="navbar-brand-text">Temasuki</span>
    </a>
    <div class="navbar-nav-links">
        <a href="{{ url('/cardapio') }}">Cardápio</a>
        @auth
            <a href="{{ url('/admin') }}">Admin</a>
            <span style="color: var(--text-muted); font-size:0.8rem; align-self:center;">{{ Auth::user()->name }}</span>
            <form action="{{ url('/logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-sm-outline" style="font-size:0.8rem; padding:0.3rem 0.75rem;">Sair</button>
            </form>
        @endauth
    </div>
</nav>

<div>
    @if(session('sucesso'))
        <div style="max-width:1000px; margin: 0 auto; padding: 0 2rem;">
            <div class="flash-sucesso mt-3">{{ session('sucesso') }}</div>
        </div>
    @endif

    @yield('content')
</div>

<footer class="footer-temasuki">
    Restaurante Temasuki &copy; {{ date('Y') }}
</footer>

@yield('scripts')
</body>
</html>
