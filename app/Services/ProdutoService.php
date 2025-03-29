<?php

namespace App\Services;

use App\Models\Produto;
use App\Repositorys\ProdutoRepository;
use Illuminate\Validation\ValidationException;

class ProdutoService
{
    private $produtoRepository;

    public function __construct(ProdutoRepository $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function createProduto(array $data)
    {
        $this->validateProduto($data);
        return $this->produtoRepository->create($data);
    }

    public function updateProduto(Produto $produto, array $data)
    {
        $this->validateProduto($data);
        return $this->produtoRepository->update($produto, $data);
    }

    public function delete(Produto $produto)
    {
        $this->produtoRepository->delete($produto);
    }

    public function getAll()
    {
        return $this->produtoRepository->getAll();
    }

    public function getById($id)
    {
        return $this->produtoRepository->getById($id);
    }

    public function validateProduto(array $data)
    {
        if (!$data['nome']) {
            throw ValidationException::withMessages(['nome' => 'O Nome do Produto é obrigatório.']);
        }

        if (!$data['preco']) {
            throw ValidationException::withMessages(['preco' => 'O Preço do Produto é obrigatório.']);
        }

        if (!$data['estoque']) {
            throw ValidationException::withMessages(['estoque' => 'O Estoque do Produto é obrigatório.']);
        }

        if (!$data['descricao']) {
            throw ValidationException::withMessages(['descricao' => 'A Descrição do Produto é obrigatório.']);
        }
    }
}