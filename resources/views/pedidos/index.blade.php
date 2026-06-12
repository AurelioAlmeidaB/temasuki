@extends('layouts.main')

@section('title', 'Pedidos — Temasuki Admin')

@section('content')
<div class="page-header">
    <h2>&#128203; Pedidos</h2>
    <a href="{{ url('/admin') }}" class="btn-outline">&#8592; Admin</a>
</div>

<div class="page-content">

    @if($pedidos->isEmpty())
        <div class="empty-state">
            <span class="empty-icon">&#128203;</span>
            <p>Nenhum pedido registrado ainda.</p>
        </div>
    @else
        <div style="overflow-x: auto;">
        <table class="table-temasuki">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Prato</th>
                    <th>Cliente</th>
                    <th>Qtd.</th>
                    <th>Preço Unit.</th>
                    <th>Total</th>
                    <th>Data</th>
                    <th>Status</th>
                    @auth<th>Ações</th>@endauth
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                <tr>
                    <td style="color: var(--text-muted);">#{{ $pedido->id }}</td>
                    <td>
                        <strong>{{ $pedido->prato ? $pedido->prato->nome : '—' }}</strong>
                        @if($pedido->prato)
                            <div style="font-size:0.75rem;color:var(--text-muted);">{{ $pedido->prato->categoria }}</div>
                        @endif
                    </td>
                    <td>{{ $pedido->cliente }}</td>
                    <td>{{ $pedido->quantidade }}</td>
                    <td style="color: var(--text-muted);">
                        {{ $pedido->prato ? 'R$ ' . number_format($pedido->prato->preco, 2, ',', '.') : '—' }}
                    </td>
                    <td style="color: var(--gold); font-weight: 700;">
                        @if($pedido->prato)
                            R$ {{ number_format($pedido->prato->preco * $pedido->quantidade, 2, ',', '.') }}
                        @else
                            —
                        @endif
                    </td>
                    <td style="color: var(--text-muted);">{{ $pedido->data_pedido->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge-status badge-status-{{ Str::slug($pedido->status ?? 'pendente') }}">
                            {{ $pedido->status ?? 'Pendente' }}
                        </span>
                    </td>
                    @auth
                    <td>
                        <a href="{{ url('/pedidos/' . $pedido->id . '/edit') }}" class="btn-sm-outline">Editar</a>
                        <form action="{{ url('/pedidos/' . $pedido->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Excluir este pedido?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-sm-danger ml-1">Excluir</button>
                        </form>
                    </td>
                    @endauth
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @endif

</div>
@endsection
