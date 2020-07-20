<?php

namespace App\Http\Controllers;

use App\Especialidade;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{

    public function __construct(){}

    public function index()
    {
        $especialidades = Especialidade::all();
        return view('especialidade.index', compact('especialidades'));
    }

    public function create(){}

    public function store(Request $request)
    {
        $especialidades = new Especialidade();
        $especialidades->nome = $request->nome;
        $especialidades->descricao = $request->descricao;

        $especialidades->save();

        return json_encode($especialidades);
    }

    public function show($id)
    {
        $dados = Especialidade::find($id);
        if (isset($dados)){
            return json_encode($dados);
        }
        return response('Especialidade não encontrada', 404);
    }

    public function edit($id){}

    public function update(Request $request, $id)
    {
        $especialidades = Especialidade::find($id);
        if(isset($especialidades)) {
            $especialidades->nome = $request->nome;
            $especialidades->descricao = $request->descricao;
            $especialidades->save();
            return json_encode($especialidades);
        }
        return response('Especialidade não encontrada', 404);
    }

    public function destroy($id)
    {
        $especialidades = Especialidade::find($id);
        if(isset($especialidades)) {
            $especialidades->delete();
            return response('OK', 200);
        }
        return response('Especialidade não encontrada', 404);
    }

    public function loadJson(){
        $especialidades = Especialidade::all();
        return json_encode($especialidades);
    }
}
