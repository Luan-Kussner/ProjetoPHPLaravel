<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    private $produtoService;

    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    public function index()
    {
        return Produto::all();
    }

    public function store(Request $request)
    {
        $request->validate($request, [
            'nome' => 'required|string',
            'preco' => 'required|numeric',
            'estoque' => 'required|numeric',
            'descricao' => 'required|string',
        ]);

        $produto = $this->produtoService->createProduto($request->all());

        return $produto;
    }

    public function show(Produto $produto)
    {
        return $produto;
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate($request, [
            'nome' => 'required|string',
            'preco' => 'required|numeric',
            'estoque' => 'required|numeric',
            'descricao' => 'required|string',
        ]);

        $produto = $this->produtoService->updateProduto($produto, $request->all());

        return $produto;
    }

    public function destroy(Produto $produto)
    {
        $this->produtoService->delete($produto);

        return response()->json(['message' => 'Produto excluído com sucesso.'], 200);
    }
}