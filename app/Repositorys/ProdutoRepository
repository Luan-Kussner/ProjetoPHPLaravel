<?php

namespace App\Repositorys;

use App\Models\Produto;

class ProdutoRepository
{
    public function getAll()
    {
        return Produto::all();
    }

    public function getById($id)
    {
        return Produto::find($id);
    }

    public function create(array $data)
    {
        return Produto::create($data);
    }

    public function update(Produto $produto, array $data)
    {
        $produto->update($data);
    }

    public function delete(Produto $produto)
    {
        $produto->delete();
    }
}