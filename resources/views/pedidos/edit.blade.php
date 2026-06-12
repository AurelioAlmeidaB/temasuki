@extends('layouts.main')

@section('title', 'Editar Pedido — Temasuki')

@section('content')
<div class="page-header">
    <h2>✏️ Editar Pedido #{{ $pedido->id }}</h2>
    <a href="{{ url('/pedidos') }}" class="btn-outline">← Voltar</a>
</div>

<div class="page-content">

    @if($errors->any())
        <div class="flash-erro" style="max-width:820px;margin:0 auto 1rem;">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    @endif

    <form action="{{ url('/pedidos/' . $pedido->id) }}" method="POST" style="max-width:820px; margin:0 auto;">
        @csrf
        @method('PUT')

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

            <div class="form-group">
                <label class="form-label">Prato *</label>
                <select name="prato_id" class="form-control-dark" required>
                    @foreach($pratos as $prato)
                        <option value="{{ $prato->id }}"
                            {{ $pedido->prato_id == $prato->id ? 'selected' : '' }}>
                            {{ $prato->nome }} ({{ $prato->categoria }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Bebida</label>
                <select name="bebida_id" class="form-control-dark">
                    <option value="">— Nenhuma —</option>
                    @foreach($bebidas as $bebida)
                        <option value="{{ $bebida->id }}"
                            {{ $pedido->bebida_id == $bebida->id ? 'selected' : '' }}>
                            {{ $bebida->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Nome do Cliente *</label>
                <input type="text" name="cliente" class="form-control-dark"
                       value="{{ old('cliente', $pedido->cliente) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Quantidade *</label>
                <input type="number" name="quantidade" class="form-control-dark"
                       value="{{ old('quantidade', $pedido->quantidade) }}" min="1" max="20" required>
            </div>

            <div class="form-group">
                <label class="form-label">Data do Pedido *</label>
                <input type="date" name="data_pedido" class="form-control-dark"
                       value="{{ old('data_pedido', $pedido->data_pedido->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Status *</label>
                <select name="status" class="form-control-dark" required>
                    @foreach($statuses as $s)
                        <option value="{{ $s }}" {{ old('status', $pedido->status) === $s ? 'selected' : '' }}>
                            {{ $s }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label">Observações</label>
                <textarea name="obs" class="form-control-dark" rows="3"
                          placeholder="Restrições alimentares, preferências...">{{ old('obs', $pedido->obs) }}</textarea>
            </div>

        </div>

        <div style="display:flex; gap:0.75rem; margin-top:1.5rem;">
            <button type="submit" class="btn-gold">Salvar alterações</button>
            <a href="{{ url('/pedidos') }}" class="btn-outline">Cancelar</a>
        </div>

    </form>
</div>
@endsection
