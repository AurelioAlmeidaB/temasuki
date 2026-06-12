<?php

namespace App\Http\Controllers;

use App\Models\Prato;
use App\Models\Pedido;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function admin()
    {
        $totalPratos = Prato::count();
        $totalPedidosHoje = Pedido::whereDate('data_pedido', today())->count();
        $totalPedidos = Pedido::count();
        $pedidosHoje = Pedido::with('prato')
            ->whereDate('data_pedido', today())
            ->orderByDesc('created_at')
            ->get();

        return view('admin.index', compact('totalPratos', 'totalPedidosHoje', 'totalPedidos', 'pedidosHoje'));
    }
}
