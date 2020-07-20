

@extends('templates.main', ['titulo' => "Informações do Cliente", 'tag' => "CLI"])

@section('titulo') {{$dados['nome']}} @endsection

@section('conteudo')

    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{$dados['id']}}</li>
        <li class="list-group-item"><b>Nome:</b> {{$dados['nome']}}</li>
        <li class="list-group-item"><b>E-mail:</b> {{$dados['email']}}</li>
        <li class="list-group-item"><b>Telefone:</b> {{$dados['telefone']}}</li>
        <li class="list-group-item">
            <a href="{{route('cliente.index')}}" class="btn btn-secondary btn-block"><b>Voltar</b></a>
        </li>
    </ul>
@endsection
