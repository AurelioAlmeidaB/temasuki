@extends('layouts.main')

@section('title', 'Cardápio — Temasuki')

@section('content')
<div class="cardapio-header">
    <h1>Cardápio</h1>
    <p>Sabores autênticos do Japão</p>
</div>

<div class="categoria-filter">
    <a href="{{ url('/cardapio') }}" class="btn-categoria all {{ !$categoria ? 'active' : '' }}">Todos</a>
    @foreach($categorias as $cat)
        <a href="{{ url('/cardapio') }}?categoria={{ urlencode($cat) }}"
           class="btn-categoria {{ $categoria === $cat ? 'active' : '' }}">
            {{ $cat }}
        </a>
    @endforeach
</div>

@if(session('sucesso'))
    <div class="container">
        <div class="flash-sucesso mt-3">{{ session('sucesso') }}</div>
    </div>
@endif

@if($pratos->isEmpty())
    <div class="empty-state">
        <span class="empty-icon">&#127843;</span>
        <p>Nenhum prato disponível{{ $categoria ? ' nesta categoria' : '' }} no momento.</p>
    </div>
@else
    <div class="pratos-grid">
        @foreach($pratos as $prato)
        <div class="prato-card">
            @if($prato->imagem)
                <img src="{{ url('/img/pratos/' . $prato->imagem) }}" alt="{{ $prato->nome }}">
            @else
                <div class="prato-card-placeholder">&#127843;</div>
            @endif
            <div class="prato-card-body">
                <div class="prato-badge">{{ $prato->categoria }}</div>
                <div class="prato-nome">{{ $prato->nome }}</div>
                <div class="prato-descricao">{{ $prato->descricao }}</div>
                <div class="prato-footer">
                    <span class="prato-preco">R$ {{ number_format($prato->preco, 2, ',', '.') }}</span>
                    <a href="{{ url('/pedidos/create') }}?prato_id={{ $prato->id }}" class="btn-red">
                        Pedir
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
