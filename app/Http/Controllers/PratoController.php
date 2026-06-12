<?php

namespace App\Http\Controllers;

use App\Models\Prato;
use Illuminate\Http\Request;

class PratoController extends Controller
{
    public function cardapio(Request $request)
    {
        $categoria = $request->categoria;

        $pratos = Prato::where('disponibilidade', 'Disponível')
            ->when($categoria, fn($q) => $q->where('categoria', $categoria))
            ->get();

        $categorias = ['Entradas', 'Sushi & Temaki', 'Pratos Quentes', 'Sobremesas', 'Bebidas'];

        return view('cardapio', compact('pratos', 'categorias', 'categoria'));
    }

    public function index()
    {
        $pratos = Prato::orderBy('categoria')->get();
        return view('pratos.index', compact('pratos'));
    }

    public function create()
    {
        $categorias = ['Entradas', 'Sushi & Temaki', 'Pratos Quentes', 'Sobremesas', 'Bebidas'];
        return view('pratos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'           => 'required|string|max:255',
            'descricao'      => 'required|string',
            'preco'          => 'required|numeric|min:0',
            'categoria'      => 'required|string',
            'disponibilidade'=> 'required|in:Disponível,Indisponível',
            'imagem'         => 'nullable|image|max:2048',
        ]);

        $dados = $request->only(['nome', 'descricao', 'preco', 'categoria', 'disponibilidade']);

        if ($request->hasFile('imagem')) {
            $arquivo = $request->file('imagem');
            $nome = time() . '_' . $arquivo->getClientOriginalName();
            $arquivo->move(public_path('img/pratos'), $nome);
            $dados['imagem'] = $nome;
        }

        Prato::create($dados);

        return redirect(url('/pratos'))->with('sucesso', 'Prato cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $prato = Prato::findOrFail($id);
        $categorias = ['Entradas', 'Sushi & Temaki', 'Pratos Quentes', 'Sobremesas', 'Bebidas'];
        return view('pratos.edit', compact('prato', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $prato = Prato::findOrFail($id);

        $request->validate([
            'nome'           => 'required|string|max:255',
            'descricao'      => 'required|string',
            'preco'          => 'required|numeric|min:0',
            'categoria'      => 'required|string',
            'disponibilidade'=> 'required|in:Disponível,Indisponível',
            'imagem'         => 'nullable|image|max:2048',
        ]);

        $dados = $request->only(['nome', 'descricao', 'preco', 'categoria', 'disponibilidade']);

        if ($request->hasFile('imagem')) {
            if ($prato->imagem && file_exists(public_path('img/pratos/' . $prato->imagem))) {
                unlink(public_path('img/pratos/' . $prato->imagem));
            }
            $arquivo = $request->file('imagem');
            $nome = time() . '_' . $arquivo->getClientOriginalName();
            $arquivo->move(public_path('img/pratos'), $nome);
            $dados['imagem'] = $nome;
        }

        $prato->update($dados);

        return redirect(url('/pratos'))->with('sucesso', 'Prato atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $prato = Prato::findOrFail($id);

        if ($prato->imagem && file_exists(public_path('img/pratos/' . $prato->imagem))) {
            unlink(public_path('img/pratos/' . $prato->imagem));
        }

        $prato->delete();

        return redirect(url('/pratos'))->with('sucesso', 'Prato removido com sucesso!');
    }
}
