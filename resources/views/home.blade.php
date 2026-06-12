<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante Temasuki</title>
    <link rel="stylesheet" href="{{ url('/css/styles.css') }}">
</head>
<body>
<div class="home-hero">
    <img src="{{ url('/img/totodile_logo.png') }}" alt="Temasuki" class="home-logo-img">
    <div class="home-logo-text">Temasuki</div>
    <div class="home-tagline">Culinária Japonesa Autêntica</div>
    <div class="home-divider"></div>
    <div class="home-cards">
        <a href="{{ url('/cardapio') }}" class="home-card">
            <div class="home-card-icon">&#127843;</div>
            <div class="home-card-title">Cliente</div>
            <div class="home-card-desc">Ver cardápio e realizar pedidos</div>
        </a>
        @auth
        <a href="{{ url('/admin') }}" class="home-card">
            <div class="home-card-icon">&#9881;</div>
            <div class="home-card-title">Admin</div>
            <div class="home-card-desc">Gerenciar pratos e pedidos</div>
        </a>
        @endauth
    </div>

    @guest
    <div style="margin-top: 2.5rem;">
        <a href="{{ url('/login') }}" class="home-admin-link">
            &#128272; Área Administrativa
        </a>
    </div>
    @endguest

    @auth
    <div style="margin-top: 2rem; display:flex; align-items:center; gap:0.75rem;">
        <span style="color: var(--text-muted); font-size:0.82rem;">{{ Auth::user()->name }}</span>
        <form action="{{ url('/logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="home-admin-link" style="background:none; border:none; cursor:pointer;">
                &#128274; Sair
            </button>
        </form>
    </div>
    @endauth
</div>
</body>
</html>
