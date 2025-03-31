<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemPedido;
use App\Services\ItemPedidoService;
use Illuminate\Http\Request;

class ItemPedidoController extends Controller
{
    private $itemPedidoService;

    public function __construct(ItemPedidoService $itemPedidoService)
    {
        $this->itemPedidoService = $itemPedidoService;
    }

    public function index()
    {
        return ItemPedido::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'pedido_id' => 'required|integer',
            'cliente_id' => 'required|integer',
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer',
            'valor_total' => 'required|numeric',
        ]);

        $itemPedido = $this->itemPedidoService->createItemPedido($request->all());
        
        return response()->json($itemPedido, 201);
    }

    public function show(ItemPedido $itemPedido)
    {
        return $itemPedido;
    }

    public function update(Request $request, $id)
    {
        $itemPedido = ItemPedido::findOrFail($id);

        $request->validate([
            'pedido_id' => 'sometimes|integer',
            'cliente_id' => 'sometimes|integer',
            'produto_id' => 'sometimes|integer',
            'quantidade' => 'sometimes|integer',
            'valor_total' => 'sometimes|numeric',
        ]);

        $itemPedido->update($request->all());
        
        return response()->json($itemPedido);
    }

    public function destroy(ItemPedido $itemPedido)
    {
        $this->itemPedidoService->delete($itemPedido);

        return response()->json(['message' => 'Item Pedido excluído com sucesso.'], 200);
    }
}