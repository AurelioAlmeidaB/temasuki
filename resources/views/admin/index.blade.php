@extends('layouts.main')

@section('title', 'Painel Admin — Temasuki')

@section('content')
<div class="page-header">
    <h2>Painel Administrativo</h2>
    <a href="{{ url('/') }}" class="btn-outline">&#8592; Início</a>
</div>

<div class="admin-outer">

    {{-- Stats --}}
    <div class="admin-stats-bar">
        <div class="admin-stat-item">
            <span class="admin-stat-number">{{ $totalPratos }}</span>
            <span class="admin-stat-label">Pratos</span>
        </div>
        <div class="admin-stat-item">
            <span class="admin-stat-number">{{ $totalPedidosHoje }}</span>
            <span class="admin-stat-label">Pedidos Hoje</span>
        </div>
        <div class="admin-stat-item">
            <span class="admin-stat-number">{{ $totalPedidos }}</span>
            <span class="admin-stat-label">Total Pedidos</span>
        </div>
    </div>

    {{-- Duas colunas --}}
    <div class="admin-columns">

        {{-- Esquerda: navegação --}}
        <div class="admin-sidebar">

            <div class="admin-nav-section">
                <div class="admin-nav-heading">Cardápio</div>
                <a href="{{ url('/pratos') }}" class="admin-nav-item">
                    <div class="admin-nav-icon">&#127859;</div>
                    <div class="admin-nav-text">
                        <div class="admin-nav-title">Gerenciar Pratos</div>
                        <div class="admin-nav-desc">Listar, editar e excluir</div>
                    </div>
                    <span class="admin-nav-arrow">&#8594;</span>
                </a>
                <a href="{{ url('/pratos/create') }}" class="admin-nav-item">
                    <div class="admin-nav-icon" style="font-size:1rem;font-weight:700;">+</div>
                    <div class="admin-nav-text">
                        <div class="admin-nav-title">Novo Prato</div>
                        <div class="admin-nav-desc">Adicionar ao cardápio</div>
                    </div>
                    <span class="admin-nav-arrow">&#8594;</span>
                </a>
            </div>

            <div class="admin-nav-section">
                <div class="admin-nav-heading">Pedidos</div>
                <a href="{{ url('/pedidos') }}" class="admin-nav-item">
                    <div class="admin-nav-icon">&#128203;</div>
                    <div class="admin-nav-text">
                        <div class="admin-nav-title">Ver Todos os Pedidos</div>
                        <div class="admin-nav-desc">Histórico completo</div>
                    </div>
                    <span class="admin-nav-arrow">&#8594;</span>
                </a>
            </div>

            <div class="admin-nav-section">
                <div class="admin-nav-heading">Visualização</div>
                <a href="{{ url('/cardapio') }}" class="admin-nav-item">
                    <div class="admin-nav-icon">&#128214;</div>
                    <div class="admin-nav-text">
                        <div class="admin-nav-title">Ver Cardápio</div>
                        <div class="admin-nav-desc">Visão do cliente</div>
                    </div>
                    <span class="admin-nav-arrow">&#8594;</span>
                </a>
            </div>

        </div>

        {{-- Direita: pedidos de hoje --}}
        <div class="admin-pedidos-panel">
            <div class="admin-pedidos-panel-header">
                <span>Pedidos de Hoje</span>
                <a href="{{ url('/pedidos') }}">Ver todos &#8594;</a>
            </div>

            @if($pedidosHoje->isEmpty())
                <div class="admin-empty-pedidos">
                    Nenhum pedido recebido hoje.
                </div>
            @else
                @foreach($pedidosHoje as $pedido)
                <div class="admin-pedido-item">
                    <div>
                        <div class="admin-pedido-nome">
                            {{ $pedido->prato ? $pedido->prato->nome : '—' }}
                        </div>
                        <div class="admin-pedido-cliente">{{ $pedido->cliente }}</div>
                    </div>
                    <div style="text-align:right;">
                        <div class="admin-pedido-total">
                            @if($pedido->prato)
                                R$ {{ number_format($pedido->prato->preco * $pedido->quantidade, 2, ',', '.') }}
                            @else — @endif
                        </div>
                        <div style="display:flex;gap:0.5rem;justify-content:flex-end;align-items:center;margin-top:2px;">
                            <span class="admin-pedido-qtd">{{ $pedido->quantidade }}x</span>
                            <span class="badge-status badge-status-{{ Str::slug($pedido->status ?? 'pendente') }}" style="font-size:0.62rem;">
                                {{ $pedido->status ?? 'Pendente' }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

    </div>

</div>
@endsection
