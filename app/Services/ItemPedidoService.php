<?php

namespace App\Services;

use App\Models\ItemPedido;
use App\Repositorys\ItemPedidoRepository;
use Illuminate\Validation\ValidationException;

class ItemPedidoService
{
    private $itemPedidoRepository;

    public function __construct(ItemPedidoRepository $itemPedidoRepository)
    {
        $this->itemPedidoRepository = $itemPedidoRepository;
    }

    public function createItemPedido(array $data)
    {
        $this->validateItemPedido($data);
        return $this->itemPedidoRepository->create($data);
    }

    public function updateItemPedido(ItemPedido $itemPedido, array $data)
    {
        $this->validateItemPedido($data);
        return $this->itemPedidoRepository->update($itemPedido, $data);
    }

    public function delete(ItemPedido $itemPedido)
    {
        $this->itemPedidoRepository->delete($itemPedido);
    }

    public function getAll()
    {
        return $this->itemPedidoRepository->getAll();
    }

    public function getById($id)
    {
        return $this->itemPedidoRepository->getById($id);
    }

    public function validateItemPedido(array $data)
    {
        if (!$data['produto_id']) {
            throw ValidationException::withMessages(['produto_id' => 'O Produto é obrigatório.']);
        }

        if (!$data['quantidade']) {
            throw ValidationException::withMessages(['quantidade' => 'A Quantidade é obrigatório.']);
        }
    }
}