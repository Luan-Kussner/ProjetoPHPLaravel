<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ItemPedidoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::apiResource('/api/v1/produtos', ProdutoController::class);
Route::apiResource('/api/v1/clientes', ClienteController::class);
Route::put('api/v1/clientes/{cliente}', [ClienteController::class, 'update']);
Route::apiResource('/api/v1/pedidos', PedidoController::class)->middleware('auth:api');
Route::apiResource('/api/v1/pedidos', PedidoController::class);
Route::apiResource('/api/v1/itens-pedidos', ItemPedidoController::class);