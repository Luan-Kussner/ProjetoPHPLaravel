<?php

namespace App\Repositorys;

use App\Models\Pedido;

class PedidoRepository
{
    public function getAll()
    {
        return Pedido::with('cliente:id,nome')->get();
    }

    public function getById($id)
    {
        return Pedido::find($id);
    }

    public function create(array $data)
    {
        return Pedido::create($data);
    }

    public function update(Pedido $pedido, array $data)
    {
        return $pedido->update($data);
    }

    public function delete(Pedido $pedido)
    {
        return $pedido->delete();
    }
}