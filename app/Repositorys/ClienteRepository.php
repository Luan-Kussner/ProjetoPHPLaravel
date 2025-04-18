<?php

namespace App\Repositorys;

use App\Models\Cliente;

class ClienteRepository
{
    public function getAll()
    {
        return Cliente::all();
    }

    public function getById($id)
    {
        return Cliente::find($id);
    }

    public function create(array $data)
    {
        return Cliente::create($data);
    }

    public function update(Cliente $cliente, array $data)
    {
       return $cliente->update($data);
    }

    public function delete(Cliente $cliente)
    {
       return $cliente->delete();
    }

    public function findByName($nome)
    {
        return Cliente::where('nome', 'like', '%' . $nome . '%')->get();
    }
}