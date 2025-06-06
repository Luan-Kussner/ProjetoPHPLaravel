<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\ItemPedidoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;

Route::post('/v1/auth/login', [AuthController::class, 'login']);
Route::post('/v1/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::apiResource('/v1/clientes', ClienteController::class);
        Route::post('/v1/clientes/find-by-name', [ClienteController::class, 'getFindByName']);
        Route::apiResource('/v1/produtos', ProdutoController::class);
        Route::post('/v1/produtos/find-by-name', [ProdutoController::class, 'getFindByName']);
    });
    Route::post('/v1/auth/logout', [AuthController::class, 'logout']);
    Route::post('/v1/auth/envia-codigo', [AuthController::class, 'envioCodigoDoisFatores']);
    Route::post('/v1/auth/verifica-codigo', [AuthController::class, 'verificacaoCodigoDoisFatores']);
    Route::middleware('auth:sanctum')->get('/v1/auth/validate', function (Request $request) {
        return response()->json($request->user());
    });
});

Route::apiResource('/v1/pedidos', PedidoController::class);
Route::apiResource('/v1/itens-pedidos', ItemPedidoController::class);
Route::get('/v1/dashboards', [DashboardsController::class, 'get']);
// Route::apiResource('/v1/produtos', ProdutoController::class); // comentado para teste sem autorização
// Route::apiResource('/v1/clientes', ClienteController::class); // comentado para teste sem autorização

Route::middleware(['auth:sanctum', 'admin'])->get('v1/admin', function () {
    return "Bem-vindo, administrador!";
});
