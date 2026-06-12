<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Prato;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['prato', 'bebida'])->orderByDesc('data_pedido')->orderByDesc('id')->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create(Request $request)
    {
        $prato = Prato::findOrFail($request->prato_id);
        $bebidas = Prato::where('categoria', 'Bebidas')->where('disponibilidade', 'Disponível')->get();
        return view('pedidos.create', compact('prato', 'bebidas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prato_id'   => 'required|exists:pratos,id',
            'cliente'    => 'required|string|max:255',
            'quantidade' => 'required|integer|min:1|max:20',
            'bebida_id'  => 'nullable|exists:pratos,id',
            'extras'     => 'nullable|array',
            'obs'        => 'nullable|string|max:500',
        ]);

        $obsPartes = [];
        if (!empty($request->extras)) {
            $obsPartes[] = 'Extras: ' . implode(', ', $request->extras);
        }
        if ($request->filled('obs')) {
            $obsPartes[] = $request->obs;
        }

        Pedido::create([
            'prato_id'    => $request->prato_id,
            'bebida_id'   => $request->bebida_id ?: null,
            'cliente'     => $request->cliente,
            'quantidade'  => $request->quantidade,
            'obs'         => $obsPartes ? implode(' | ', $obsPartes) : null,
            'data_pedido' => today(),
            'status'      => 'Pendente',
        ]);

        return redirect(url('/cardapio'))->with('sucesso', 'Pedido realizado com sucesso!');
    }

    public function edit($id)
    {
        $pedido   = Pedido::with(['prato', 'bebida'])->findOrFail($id);
        $pratos   = Prato::where('disponibilidade', 'Disponível')->get();
        $bebidas  = Prato::where('categoria', 'Bebidas')->where('disponibilidade', 'Disponível')->get();
        $statuses = ['Pendente', 'Em preparo', 'Pronto', 'Entregue'];
        return view('pedidos.edit', compact('pedido', 'pratos', 'bebidas', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $request->validate([
            'prato_id'    => 'required|exists:pratos,id',
            'cliente'     => 'required|string|max:255',
            'quantidade'  => 'required|integer|min:1|max:20',
            'bebida_id'   => 'nullable|exists:pratos,id',
            'obs'         => 'nullable|string|max:500',
            'data_pedido' => 'required|date',
            'status'      => 'required|in:Pendente,Em preparo,Pronto,Entregue',
        ]);

        $pedido->update([
            'prato_id'    => $request->prato_id,
            'bebida_id'   => $request->bebida_id ?: null,
            'cliente'     => $request->cliente,
            'quantidade'  => $request->quantidade,
            'obs'         => $request->obs,
            'data_pedido' => $request->data_pedido,
            'status'      => $request->status,
        ]);

        return redirect(url('/pedidos'))->with('sucesso', 'Pedido atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Pedido::findOrFail($id)->delete();
        return redirect(url('/pedidos'))->with('sucesso', 'Pedido removido com sucesso!');
    }
}
