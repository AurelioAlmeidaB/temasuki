@extends('layouts.main')

@section('title', 'Login — Temasuki Admin')

@section('content')
<div style="min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">
    <div class="login-card">

        <div style="text-align:center; margin-bottom: 2rem;">
            <span style="font-size: 2.5rem;">🔐</span>
            <h2 style="margin: 0.5rem 0 0.25rem; font-size: 1.4rem; letter-spacing: 2px;">ACESSO ADMIN</h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">Área restrita — Temasuki</p>
        </div>

        @if($errors->any())
            <div class="flash-erro" style="margin-bottom: 1.25rem;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control-dark"
                       value="{{ old('email') }}" placeholder="admin@temasuki.com"
                       autofocus required>
            </div>

            <div class="form-group">
                <label class="form-label">Senha</label>
                <input type="password" name="password" class="form-control-dark"
                       placeholder="••••••••" required>
            </div>

            <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:1.5rem;">
                <input type="checkbox" name="remember" id="remember"
                       style="accent-color: var(--vermelho); width:16px; height:16px;">
                <label for="remember" style="color: var(--text-muted); font-size:0.85rem; cursor:pointer;">
                    Manter conectado
                </label>
            </div>

            <button type="submit" class="btn-gold" style="width:100%; justify-content:center;">
                Entrar
            </button>
        </form>

        <div style="text-align:center; margin-top:1.5rem;">
            <a href="{{ url('/cardapio') }}" style="color: var(--text-muted); font-size:0.82rem; text-decoration:none;">
                ← Voltar ao cardápio
            </a>
        </div>

    </div>
</div>
@endsection
