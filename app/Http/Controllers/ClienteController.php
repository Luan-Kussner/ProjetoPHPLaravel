<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    private $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    public function index(Request $request)
    {
        $pageSize = $request->input('pageSize', 10);
        $clientes = Cliente::paginate($pageSize);

        return response()->json([
            'items' => $clientes->items(),
            'totalItems' => $clientes->total(),
            'totalPages' => $clientes->lastPage(),
            'pageNumber' => $clientes->currentPage()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'telefone' => 'required|string',
            'endereco' => 'required|string',
            'numero' => 'required|string',
            'bairro' => 'required|string',
            'objectkey' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        $data = $request->only(['nome', 'telefone', 'endereco', 'numero', 'bairro']);
    
        // Se veio imagem, salva no storage e adiciona ao $data
        if ($request->hasFile('objectkey')) {
            $path = $request->file('objectkey')->store('clientes', 'public'); // salva em storage/app/public/clientes
            $data['objectkey'] = $path;
        }
    
        // Chama o service para salvar no banco
        $cliente = $this->clienteService->createCliente($data);
    
        return response()->json($cliente, 201);
    }
    

    public function show(Cliente $cliente)
    {
        return $cliente;
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
