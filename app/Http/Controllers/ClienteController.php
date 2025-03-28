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
        $request->validate($request, [
            'nome' => 'required|string',
            'telefone' => 'required|string',
            'endereco' => 'required|string',
            'numero' => 'required|string',
            'bairro' => 'required|string'
        ]);

        $cliente = $this->clienteService->createCliente($request->all());

        return $cliente;
    }

    public function show(Cliente $cliente)
    {
        return $cliente;
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate($request, [
            'nome' => 'required|string',
            'telefone' => 'required|string',
            'endereco' => 'required|string',
            'numero' => 'required|string',
            'bairro' => 'required|string'
        ]);

        $cliente = $this->clienteService->updateCliente($cliente, $request->all());

        return $cliente;
    }

    public function destroy(Cliente $cliente)
    {
        $this->clienteService->delete($cliente);

        return response()->json(['message' => 'Cliente excluído com sucesso.'], 200);
    }
}