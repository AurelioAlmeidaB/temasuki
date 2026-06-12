@extends('layouts.main')

@section('title', 'Pratos — Temasuki Admin')

@section('content')
<div class="page-header">
    <h2>&#127859; Pratos</h2>
    <div style="display:flex; gap: 0.5rem;">
        <a href="{{ url('/admin') }}" class="btn-outline">&#8592; Admin</a>
        <a href="{{ url('/pratos/create') }}" class="btn-gold">+ Novo Prato</a>
    </div>
</div>

<div class="page-content">

    @if($pratos->isEmpty())
        <div class="empty-state">
            <span class="empty-icon">&#127859;</span>
            <p>Nenhum prato cadastrado ainda.</p>
            <a href="{{ url('/pratos/create') }}" class="btn-gold mt-3">Cadastrar primeiro prato</a>
        </div>
    @else
        <div style="overflow-x: auto;">
        <table class="table-temasuki">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Disponibilidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pratos as $prato)
                <tr>
                    <td>
                        @if($prato->imagem)
                            <img src="{{ url('/img/pratos/' . $prato->imagem) }}" class="table-img" alt="{{ $prato->nome }}">
                        @else
                            <div style="width:50px;height:50px;background:#1a0505;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;opacity:0.6;">&#127843;</div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $prato->nome }}</strong>
                        <div style="font-size:0.78rem;color:var(--text-muted);margin-top:2px;">{{ Str::limit($prato->descricao, 60) }}</div>
                    </td>
                    <td>{{ $prato->categoria }}</td>
                    <td style="color: var(--gold); font-weight: 700;">R$ {{ number_format($prato->preco, 2, ',', '.') }}</td>
                    <td>
                        @if($prato->disponibilidade === 'Disponível')
                            <span class="badge-disponivel">Disponível</span>
                        @else
                            <span class="badge-indisponivel">Indisponível</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('/pratos/' . $prato->id . '/edit') }}" class="btn-sm-outline">Editar</a>
                        <form action="{{ url('/pratos/' . $prato->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Excluir este prato?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-sm-danger ml-1">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @endif

</div>
@endsection
