<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Services\PedidoService;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    private $pedidoService;

    public function __construct(PedidoService $pedidoService)
    {
        $this->pedidoService = $pedidoService;
    }

    public function index()
    {
        return Pedido::all();
    }

    public function store(Request $request)
    {
        $request->validate($request, [
            'cliente_id' => 'required|integer',
            'valor_total' => 'required|numeric',
        ]);

        $pedido = $this->pedidoService->createPedido($request->all());

        return $pedido;
    }

    public function show(Pedido $pedido)
    {
        return $pedido;
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate($request, [
            'valor_total' => 'required|numeric',
        ]);

        $pedido = $this->pedidoService->updatePedido($pedido, $request->all());

        return $pedido;
    }

    public function destroy(Pedido $pedido)
    {
        $this->pedidoService->delete($pedido);

        return response()->json(['message' => 'Pedido excluído com sucesso.'], 200);
    }
}