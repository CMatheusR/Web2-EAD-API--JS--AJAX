<?php

namespace App\Http\Controllers;

use App\Cliente;
use http\Env\Response;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct(){}

    public function index()
    {
        $clientes = Cliente::all();
        return view('cliente.index', compact('clientes'));
    }

    public function create(){}

    public function store(Request $request)
    {

        $cliente = new Cliente();
        $cliente->nome = $request->nome;
        $cliente->email = $request->email;
        $cliente->telefone = $request->telefone;

        $cliente->save();

        return json_encode($cliente);
    }

    public function show($id)
    {
        $dados = Cliente::find($id);
        if (isset($dados)) {
            return json_encode($dados);
        }
        return response('Cliente não encontrado', 404);
    }

    public function edit($id){}

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        if (isset($cliente)) {
            $cliente->nome = $request->nome;
            $cliente->email = $request->email;
            $cliente->telefone = $request->telefone;
            $cliente->save();
            return json_encode($cliente);
        }
        return response('Cliente não encontrado', 404);
    }

    public function destroy($id)
    {

        $cliente = Cliente::find($id);
        if (isset($cliente)) {
            $cliente->delete();
            return response('OK', 200);
        }
        return response('Cliente não encontrado', 404);
    }

    public function loadJson(){
        $clientes = Cliente::all();
        return json_encode($clientes);
    }
}
