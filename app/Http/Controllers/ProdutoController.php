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

    public function index(Request $request)
    {
        try {
            $pageSize = (int) $request->input('pageSize', 10);
    
            if ($pageSize <= 0) {
                return response()->json(['error' => 'O valor de pageSize deve ser maior que 0'], 400);
            }
    
            $produtos = Produto::paginate($pageSize);
    
            $produtos->getCollection()->transform(function ($produto) {
                return $produto;
            });
    
            return response()->json([
                'items' => $produtos->items(),
                'totalItems' => $produtos->total(),
                'totalPages' => $produtos->lastPage(),
                'pageNumber' => $produtos->currentPage(),
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao processar a requisição', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'preco' => 'required|numeric',
            'estoque' => 'required|numeric',
            'descricao' => 'required|string',
        ]);

        $produto = $this->produtoService->createProduto($request->all());

        return response()->json($produto, 201);
    }

    public function show(Produto $produto)
    {
        return $produto;
    }

    public function update(Request $request,$id)
    {
        $produto = Produto::findOrFail($id);

        $request->validate([
            'nome' => 'sometimes|string',
            'preco' => 'sometimes|numeric',
            'estoque' => 'sometimes|numeric',
            'descricao' => 'sometimes|string',
        ]);

        $produto->update($request->all());
    
        return response()->json($produto);
    }

    public function destroy(Produto $produto)
    {
        $this->produtoService->delete($produto);

        return response()->json(['message' => 'Produto excluído com sucesso.'], 200);
    }
}