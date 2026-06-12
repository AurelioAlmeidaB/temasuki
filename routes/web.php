<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PratoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\AuthController;

// Público
Route::get('/', [HomeController::class, 'index']);
Route::get('/cardapio', [PratoController::class, 'cardapio']);
Route::get('/pedidos', [PedidoController::class, 'index']);
Route::get('/pedidos/create', [PedidoController::class, 'create']);
Route::post('/pedidos', [PedidoController::class, 'store']);

// Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Área admin — tudo exige autenticação
Route::middleware('auth')->group(function () {
    Route::get('/admin', [HomeController::class, 'admin']);

    // Pratos
    Route::get('/pratos', [PratoController::class, 'index']);
    Route::get('/pratos/create', [PratoController::class, 'create']);
    Route::post('/pratos', [PratoController::class, 'store']);
    Route::get('/pratos/{id}/edit', [PratoController::class, 'edit']);
    Route::put('/pratos/{id}', [PratoController::class, 'update']);
    Route::delete('/pratos/{id}', [PratoController::class, 'destroy']);

    // Pedidos
    Route::get('/pedidos/{id}/edit', [PedidoController::class, 'edit']);
    Route::put('/pedidos/{id}', [PedidoController::class, 'update']);
    Route::delete('/pedidos/{id}', [PedidoController::class, 'destroy']);
});
