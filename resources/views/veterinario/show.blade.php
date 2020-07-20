

@extends('templates.main', ['titulo' => "Informações da Veterinario", 'tag' => "VET"])

@section('titulo') {{$dados['nome']}} @endsection

@section('conteudo')

    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{$dados['id']}}</li>
        <li class="list-group-item"><b>Nome:</b> {{$dados['nome']}}</li>
        <li class="list-group-item"><b>Descrição:</b> {{$espec['nome']}}</li>
        <li class="list-group-item">
            <a href="{{route('veterinario.index')}}" class="btn btn-secondary btn-block"><b>Voltar</b></a>
        </li>
    </ul>
@endsection
