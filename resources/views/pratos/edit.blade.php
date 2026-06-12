@extends('layouts.main')

@section('title', 'Editar Prato — Temasuki')

@section('content')
<div class="page-header">
    <h2>Editar Prato</h2>
    <a href="{{ url('/pratos') }}" class="btn-outline">&#8592; Voltar</a>
</div>

<div class="page-content">

    @if($errors->any())
        <div class="flash-erro" style="max-width:820px;margin:0 auto 1rem;">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    @endif

    <form action="{{ url('/pratos/' . $prato->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-prato-layout">

            {{-- Coluna esquerda: prévia --}}
            <div class="form-prato-preview">
                <div class="img-preview-box {{ $prato->imagem ? 'has-image' : '' }}" id="preview-box">
                    <span class="preview-placeholder">&#127843;</span>
                    <img id="img-preview"
                         src="{{ $prato->imagem ? url('/img/pratos/' . $prato->imagem) : '' }}"
                         alt="{{ $prato->nome }}">
                </div>
                <label class="form-label" style="margin-bottom:0.3rem;">
                    {{ $prato->imagem ? 'Substituir foto' : 'Foto do Prato' }}
                </label>
                <input type="file" name="imagem" id="imagem-input" class="form-control-dark"
                       accept="image/*" onchange="mostrarPrevia(this)">
                <small style="color:var(--text-muted);font-size:0.72rem;">
                    {{ $prato->imagem ? 'Deixe vazio para manter a imagem atual.' : 'JPG, PNG, WEBP · máx. 2MB' }}
                </small>
            </div>

            {{-- Coluna direita: campos --}}
            <div class="form-prato-fields">
                <div class="form-group">
                    <label class="form-label">Nome do Prato *</label>
                    <input type="text" name="nome" class="form-control-dark"
                           value="{{ old('nome', $prato->nome) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Descrição *</label>
                    <textarea name="descricao" class="form-control-dark" rows="3" required>{{ old('descricao', $prato->descricao) }}</textarea>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">Preço (R$) *</label>
                        <input type="number" name="preco" class="form-control-dark"
                               value="{{ old('preco', $prato->preco) }}" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Categoria *</label>
                        <select name="categoria" class="form-control-dark" required>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat }}" {{ old('categoria', $prato->categoria) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Disponibilidade *</label>
                    <select name="disponibilidade" class="form-control-dark" required>
                        <option value="Disponível" {{ old('disponibilidade', $prato->disponibilidade) === 'Disponível' ? 'selected' : '' }}>Disponível</option>
                        <option value="Indisponível" {{ old('disponibilidade', $prato->disponibilidade) === 'Indisponível' ? 'selected' : '' }}>Indisponível</option>
                    </select>
                </div>

                <div style="display:flex;gap:0.8rem;justify-content:flex-end;margin-top:0.5rem;">
                    <a href="{{ url('/pratos') }}" class="btn-outline">Cancelar</a>
                    <button type="submit" class="btn-gold">Atualizar Prato</button>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection

@section('scripts')
<script>
function mostrarPrevia(input) {
    const box = document.getElementById('preview-box');
    const img = document.getElementById('img-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            box.classList.add('has-image');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
