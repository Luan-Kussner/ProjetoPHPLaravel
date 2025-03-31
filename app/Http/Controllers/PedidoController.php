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
        $request->validate([
            'cliente_id' => 'required|integer',
            'valor_total' => 'required|numeric',
        ]);

        $pedido = $this->pedidoService->createPedido($request->all());

        return response()->json($pedido, 201);
    }

    public function show(Pedido $pedido)
    {
        return $pedido;
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $request->validate([
            'cliente_id' => 'sometimes|numeric',
            'valor_total' => 'sometimes|numeric',
        ]);

        $pedido->update($request->all());

        return response()->json($pedido);
    }

    public function destroy(Pedido $pedido)
    {
        $this->pedidoService->delete($pedido);

        return response()->json(['message' => 'Pedido excluído com sucesso.'], 200);
    }
}