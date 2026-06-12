@extends('layouts.main')

@section('title', 'Fazer Pedido — Temasuki')

@section('content')
<div class="page-header">
    <h2>Fazer Pedido</h2>
    <a href="{{ url('/cardapio') }}" class="btn-outline">&#8592; Cardápio</a>
</div>

<div class="page-content">
<div class="pedido-form-wrap">

    @if($errors->any())
        <div class="flash-erro" style="margin-bottom:1rem;">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    @endif

    <form action="{{ url('/pedidos') }}" method="POST" id="pedido-form">
        @csrf
        <input type="hidden" name="prato_id" value="{{ $prato->id }}">

        {{-- Prato selecionado --}}
        <div class="pedido-section">
            <div class="pedido-section-header">Prato selecionado</div>
            <div class="pedido-section-body">
                <div style="display:flex; gap:1.2rem; align-items:center;">
                    @if($prato->imagem)
                        <img src="{{ url('/img/pratos/' . $prato->imagem) }}" style="width:80px;height:80px;object-fit:cover;border-radius:4px;flex-shrink:0;" alt="{{ $prato->nome }}">
                    @else
                        <div style="width:80px;height:80px;background:#1a0505;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;opacity:0.5;flex-shrink:0;">&#127843;</div>
                    @endif
                    <div style="flex:1;">
                        <div style="font-size:0.65rem;letter-spacing:1.5px;text-transform:uppercase;color:var(--red-light);">{{ $prato->categoria }}</div>
                        <div style="font-size:1.05rem;font-weight:700;color:var(--text-light);margin:0.2rem 0;">{{ $prato->nome }}</div>
                        <div style="font-size:0.8rem;color:var(--text-muted);">{{ $prato->descricao }}</div>
                    </div>
                    <div style="font-size:1.2rem;font-weight:800;color:var(--text-light);flex-shrink:0;">
                        R$ {{ number_format($prato->preco, 2, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Identificação + Quantidade --}}
        <div class="pedido-section">
            <div class="pedido-section-header">Seu pedido</div>
            <div class="pedido-section-body">
                <div style="display:grid;grid-template-columns:1fr auto;gap:1.2rem;align-items:end;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Seu nome *</label>
                        <input type="text" name="cliente" class="form-control-dark"
                               value="{{ old('cliente') }}" placeholder="Como devemos te chamar?" required>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Quantidade *</label>
                        <div class="qtd-control">
                            <button type="button" class="qtd-btn" onclick="alterarQtd(-1)">&#8722;</button>
                            <input type="number" name="quantidade" id="quantidade" class="qtd-input"
                                   value="{{ old('quantidade', 1) }}" min="1" max="20" required
                                   oninput="calcularTotal()">
                            <button type="button" class="qtd-btn" onclick="alterarQtd(1)">&#43;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Adicionais --}}
        <div class="pedido-section">
            <div class="pedido-section-header">Adicionais</div>
            <div class="pedido-section-body">
                <div class="extras-grid">
                    @foreach(['Wasabi extra', 'Gengibre extra', 'Molho de soja extra', 'Sem pimenta', 'Sem cebola', 'Bem temperado'] as $extra)
                    <label class="extra-item" id="label-{{ Str::slug($extra) }}">
                        <input type="checkbox" name="extras[]" value="{{ $extra }}"
                               onchange="toggleChecked(this, 'label-{{ Str::slug($extra) }}')">
                        {{ $extra }}
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Bebidas --}}
        <div class="pedido-section">
            <div class="pedido-section-header">Adicionar bebida</div>
            <div class="pedido-section-body">
                @if($bebidas->isEmpty())
                    <p style="color:var(--text-muted);font-size:0.82rem;margin:0;">Nenhuma bebida disponível no momento.</p>
                @else
                    <div class="bebida-opcoes">
                        <label class="bebida-opcao checked" id="bebida-nenhuma">
                            <input type="radio" name="bebida_id" value="" checked
                                   onchange="selecionarBebida('nenhuma', 0)">
                            <span>Nenhuma</span>
                        </label>
                        @foreach($bebidas as $beb)
                        <label class="bebida-opcao" id="bebida-{{ $beb->id }}">
                            <input type="radio" name="bebida_id" value="{{ $beb->id }}"
                                   onchange="selecionarBebida('{{ $beb->id }}', {{ $beb->preco }})">
                            <span>{{ $beb->nome }}</span>
                            <span class="bebida-preco">R$ {{ number_format($beb->preco, 2, ',', '.') }}</span>
                        </label>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Observações --}}
        <div class="pedido-section">
            <div class="pedido-section-header">Observações</div>
            <div class="pedido-section-body">
                <textarea name="obs" class="form-control-dark" rows="2"
                          placeholder="Alguma observação especial? Ex: alergia, ponto da carne...">{{ old('obs') }}</textarea>
            </div>
        </div>

        {{-- Resumo + botões --}}
        <div class="pedido-resumo">
            <div class="resumo-linha">
                <span id="resumo-prato-label">{{ $prato->nome }} × 1</span>
                <span id="resumo-prato-valor">R$ {{ number_format($prato->preco, 2, ',', '.') }}</span>
            </div>
            <div class="resumo-linha" id="resumo-bebida-row" style="display:none;">
                <span id="resumo-bebida-label">—</span>
                <span id="resumo-bebida-valor">—</span>
            </div>
            <div class="resumo-linha total">
                <span>Total</span>
                <span id="resumo-total">R$ {{ number_format($prato->preco, 2, ',', '.') }}</span>
            </div>
        </div>

        <div style="display:flex;gap:0.8rem;justify-content:flex-end;">
            <a href="{{ url('/cardapio') }}" class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-red" style="padding:0.55rem 2rem;font-size:0.95rem;">
                Confirmar Pedido
            </button>
        </div>
    </form>

</div>
</div>
@endsection

@section('scripts')
<script>
const precoPrato = {{ $prato->preco }};
let precoBebida = 0;
let nomeBebida = '';

function fmt(v) {
    return 'R$ ' + v.toFixed(2).replace('.', ',');
}

function calcularTotal() {
    const qtd = parseInt(document.getElementById('quantidade').value) || 1;
    const subtPrato = precoPrato * qtd;
    const total = subtPrato + precoBebida;

    document.getElementById('resumo-prato-label').textContent = '{{ $prato->nome }} × ' + qtd;
    document.getElementById('resumo-prato-valor').textContent = fmt(subtPrato);
    document.getElementById('resumo-total').textContent = fmt(total);
}

function selecionarBebida(id, preco) {
    document.querySelectorAll('.bebida-opcao').forEach(el => el.classList.remove('checked'));
    document.getElementById('bebida-' + id)?.classList.add('checked');
    if (id === 'nenhuma') {
        document.getElementById('bebida-nenhuma').classList.add('checked');
    }

    precoBebida = preco;
    const row = document.getElementById('resumo-bebida-row');
    if (preco > 0) {
        document.getElementById('resumo-bebida-label').textContent = 'Bebida × 1';
        document.getElementById('resumo-bebida-valor').textContent = fmt(preco);
        row.style.display = 'flex';
    } else {
        row.style.display = 'none';
    }
    calcularTotal();
}

function alterarQtd(delta) {
    const input = document.getElementById('quantidade');
    const nova = Math.min(20, Math.max(1, (parseInt(input.value) || 1) + delta));
    input.value = nova;
    calcularTotal();
}

function toggleChecked(checkbox, labelId) {
    const label = document.getElementById(labelId);
    label.classList.toggle('checked', checkbox.checked);
}
</script>
@endsection
