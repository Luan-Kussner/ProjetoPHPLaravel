<?php 

namespace App\Services;

use App\Models\Cliente;
use App\Repositorys\ClienteRepository;
use Illuminate\Validation\ValidationException;

class ClienteService
{
    private $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function createCliente(array $data)
    {
        $this->validateCliente($data);
        return $this->clienteRepository->create($data);
    }

    public function updateCliente(Cliente $cliente, array $data)
    {
        $this->validateCliente($data);
        return $this->clienteRepository->update($cliente, $data);
    }

    public function delete(Cliente $cliente)
    {
        $this->clienteRepository->delete($cliente);
    }

    public function getAll()
    {
        return $this->clienteRepository->getAll();
    }

    public function getById($id)
    {
        return $this->clienteRepository->getById($id);
    }

    public function validateCliente(array $data)
    {
        if (!$data['nome']) {
            throw ValidationException::withMessages(['nome' => 'O Nome é obrigatório.']);
        }

        if(!$data['telefone']) {
            throw ValidationException::withMessages(['telefone' => 'O Telefone é obrigatório.']);
        }

        if(!$data['endereco']) {
            throw ValidationException::withMessages(['endereco' => 'O Endereço é obrigatório.']);
        }

        if(!$data['numero']) {
            throw ValidationException::withMessages(['numero' => 'O Número é obrigatório.']);
        }

        if(!$data['bairro']) {
            throw ValidationException::withMessages(['bairro' => 'O Bairro é obrigatório.']);
        }
    }
}