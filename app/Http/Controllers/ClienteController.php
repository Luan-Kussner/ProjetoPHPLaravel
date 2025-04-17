<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{
    private $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    public function index(Request $request)
    {
        try {
            $pageSize = (int) $request->input('pageSize', 10);
    
            if ($pageSize <= 0) {
                return response()->json(['error' => 'O valor de pageSize deve ser maior que 0'], 400);
            }
    
            $clientes = Cliente::paginate($pageSize);
    
            $clientes->getCollection()->transform(function ($cliente) {
                if ($cliente->objectkey) {
                    $cliente->objectkey = asset('storage/' . $cliente->objectkey);
                }
                return $cliente;
            });
    
            return response()->json([
                'items' => $clientes->items(),
                'totalItems' => $clientes->total(),
                'totalPages' => $clientes->lastPage(),
                'pageNumber' => $clientes->currentPage(),
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
                'telefone' => 'required|string',
                'endereco' => 'required|string',
                'numero' => 'required|string',
                'bairro' => 'required|string',
                'objectkey' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
    
            $data = $request->only(['nome', 'telefone', 'endereco', 'numero', 'bairro']);
    
            if ($request->hasFile('objectkey')) {
                $path = $request->file('objectkey')->store('clientes', 'public');
                $data['objectkey'] = $path;
            }
    
            $cliente = $this->clienteService->createCliente($data);
    
            return response()->json($cliente, 201);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar cliente', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Cliente $cliente)
    {
        if ($cliente->objectkey) {
            $cliente->objectkey = asset('storage/' . $cliente->objectkey);
        }
    
        return response()->json($cliente);
    }
    

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nome' => 'sometimes|string',
            'telefone' => 'sometimes|string',
            'endereco' => 'sometimes|string',
            'numero' => 'sometimes|string',
            'bairro' => 'sometimes|string',
            'objectkey' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('objectkey')) {

            if ($cliente->objectkey && Storage::disk('public')->exists($cliente->objectkey)) {
                Storage::disk('public')->delete($cliente->objectkey);
            }

            $path = $request->file('objectkey')->store('clientes', 'public');
            $data['objectkey'] = $path;
        }

        $cliente->update($data);

        return response()->json($cliente);
    }

    public function destroy(Cliente $cliente)
    {
        $this->clienteService->delete($cliente);

        return response()->json(['message' => 'Cliente excluído com sucesso.'], 200);
    }
}
