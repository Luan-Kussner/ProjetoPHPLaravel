<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    public function index()
    {
        return Cliente::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'telefone' => 'required|string',
            'endereco' => 'required|string',
            'numero' => 'required|string',
            'bairro' => 'required|string'
        ]);
    
        $cliente = $this->clienteService->createCliente($request->all());
    
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
            'bairro' => 'sometimes|string'
        ]);
    
        $cliente->update($request->all());
    
        return response()->json($cliente);
    }

    public function destroy(Cliente $cliente)
    {
        $this->clienteService->delete($cliente);

        return response()->json(['message' => 'Cliente excluído com sucesso.'], 200);
    }
}