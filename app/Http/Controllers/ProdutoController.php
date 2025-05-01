<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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
                if ($produto->objectkey) {
                    $produto->objectkey = asset('storage/' . $produto->objectkey);
                }
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
        try {
            $request->validate([
                'nome' => 'required|string',
                'preco' => 'required|numeric',
                'estoque' => 'required|numeric',
                'descricao' => 'required|string',
                'objectkey' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
            
            $data = $request->only(['nome', 'preco', 'estoque', 'descricao']);
        
            if ($request->hasFile('objectkey')) {
                $path = $request->file('objectkey')->store('produtos', 'public');
                $data['objectkey'] = $path;
            }

            $produto = $this->produtoService->createProduto($data);

            return response()->json($produto, 201);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar cliente', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Produto $produto)
    {
        if ($produto->objectkey) {
            $produto->objectkey = asset('storage/' . $produto->objectkey);
        }
    
        return response()->json($produto);
    }

    public function update(Request $request,$id)
    {
        $produto = Produto::findOrFail($id);

        $request->validate([
            'nome' => 'sometimes|string',
            'preco' => 'sometimes|numeric',
            'estoque' => 'sometimes|numeric',
            'descricao' => 'sometimes|string',
            'objectkey' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $data = $request->all();

        if ($request->hasFile('objectkey')) {

            if ($produto->objectkey && Storage::disk('public')->exists($produto->objectkey)) {
                Storage::disk('public')->delete($produto->objectkey);
            }

            $path = $request->file('objectkey')->store('produtos', 'public');
            $data['objectkey'] = $path;
        }

        $produto->update($data);

        return response()->json($produto);
    }

    public function destroy(Produto $produto)
    {
        $this->produtoService->delete($produto);

        return response()->json(['message' => 'Produto excluído com sucesso.'], 200);
    }

    public function getfindByName(Request $request)
    {
        try {
            $nome = $request->input('nome');
            $produtos = $this->produtoService->findByName($nome);
    
            foreach ($produtos as &$produto) {
                if (!empty($produto['objectkey'])) {
                    $produto['objectkey'] = asset('storage/' . $produto['objectkey']);
                }
            }
    
            return response()->json($produtos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar produtos', 'message' => $e->getMessage()], 500);
        }
    }
}