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
        $request->validate($request, [
            'pedido_id' => 'required|integer',
            'cliente_id' => 'required|integer',
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer',
            'valor_total' => 'required|numeric',
        ]);

        $itemPedido = $this->itemPedidoService->createItemPedido($request->all());

        return $itemPedido;
    }

    public function show(ItemPedido $itemPedido)
    {
        return $itemPedido;
    }

    public function update(Request $request, ItemPedido $itemPedido)
    {
        $request->validate($request, [
            'pedido_id' => 'required|integer',
            'cliente_id' => 'required|integer',
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer',
            'valor_total' => 'required|numeric',
        ]);

        $itemPedido = $this->itemPedidoService->updateItemPedido($itemPedido, $request->all());

        return $itemPedido;
    }

    public function destroy(ItemPedido $itemPedido)
    {
        $this->itemPedidoService->delete($itemPedido);

        return response()->json(['message' => 'Item Pedido excluído com sucesso.'], 200);
    }
}