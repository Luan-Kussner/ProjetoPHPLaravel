<?php

namespace App\Repositorys;

use App\Models\Cliente;
use App\Models\ItemPedido;
use App\Models\Pedido;
use App\Models\Produto;

class DashboardRepository
{
    public function getDatas()
    {
        return [
            'totalClientes' => Cliente::count(),
            'totalProdutos' => Produto::count(),
            'totalItemPedidos' => ItemPedido::count(),
            'produtoMaisVendido' => $this->productBestSeller(),
        ];
    }

    public function productBestSeller()
    {
        $bestSeller = ItemPedido::selectRaw('produto_id, COUNT(*) as total_controls')
            ->groupBy('produto_id')
            ->orderByDesc('total_controls')
            ->first();

        return $bestSeller ? $bestSeller->total_controls : 0;
    }
}
