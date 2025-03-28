<?php

namespace App\Repositorys;

use App\Models\ItemPedido;

class ItemPedidoRepository
{
    public function getAll()
    {
        return ItemPedido::all();
    }

    public function getById($id)
    {
        return ItemPedido::find($id);
    }

    public function create(array $data)
    {
        return ItemPedido::create($data);
    }

    public function update(ItemPedido $itemPedido, array $data)
    {
        $itemPedido->update($data);
    }

    public function delete(ItemPedido $itemPedido)
    {
        $itemPedido->delete();
    }
}