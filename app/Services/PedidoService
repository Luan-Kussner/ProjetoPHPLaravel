<?php

namespace App\Services;

use App\Models\Pedido;
use App\Repositorys\PedidoRepository;
use Illuminate\Validation\ValidationException;

class PedidoService
{
    private $pedidoRepository;

    public function __construct(PedidoRepository $pedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
    }

    public function createPedido(array $data)
    {
        if ($data['valor_total'] <= 0) {
            throw ValidationException::withMessages(['valor_total' => 'O valor total deve ser maior que zero.']);
        }

        return $this->pedidoRepository->create($data);
    }

    public function updatePedido(Pedido $pedido, array $data)
    {
        if ($data['valor_total'] <= 0) {
            throw ValidationException::withMessages(['valor_total' => 'O valor total deve ser maior que zero.']);
        }

        return $this->pedidoRepository->update($pedido, $data);
    }

    public function delete(Pedido $pedido)
    {
        $this->pedidoRepository->delete($pedido);
    }

    public function getAll()
    {
        return $this->pedidoRepository->getAll();
    }

    public function getById($id)
    {
        return $this->pedidoRepository->getById($id);
    }
}