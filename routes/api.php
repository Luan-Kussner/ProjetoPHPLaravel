<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ItemPedidoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;

Route::post('/v1/login', [AuthController::class, 'login']);
Route::post('/v1/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::apiResource('/v1/clientes', ClienteController::class);
    });
});

Route::apiResource('/v1/pedidos', PedidoController::class);
Route::apiResource('/v1/itens-pedidos', ItemPedidoController::class);
Route::apiResource('/v1/produtos', ProdutoController::class);

// Rota do painel de administração, protegida com middleware de admin
Route::middleware(['auth:sanctum', 'admin'])->get('v1/admin', function () {
    return "Bem-vindo, administrador!";
});
