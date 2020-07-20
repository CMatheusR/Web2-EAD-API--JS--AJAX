@extends('templates.main', ['titulo' => "Alterar Especialidade", 'tag' => "ESP"])

@section('titulo') {{$dados['nome']}} @endsection

@section('conteudo')

    <form action="{{ route('especialidade.update', $dados['id']) }}" method="POST">
    @csrf
        @method('PUT')
        <div class="form-group">
            <div class='col-sm-16'>
                <label>Nome</label>
                <input type="text" class="form-control {{$errors->has('nome') ? 'is-invalid' : ''}}" name="nome" value="{{$dados['nome']}}">
                @if($errors->has('nome'))
                    <div class="invalid-feedback">
                        {{$errors->first('nome')}}
                    </div>
                @endif
            </div>
            <div class='col-sm-16 '>
                <label>Descrição</label>
                <textarea class="form-control {{$errors->has('descricao') ? 'is-invalid' : ''}}" name="descricao" >{{$dados['descricao']}}</textarea>
                @if($errors->has('descricao'))
                    <div class="invalid-feedback">
                        {{$errors->first('descricao')}}
                    </div>
                @endif
            </div>
            <div class='row' style="margin-top:20px">
                <div class='col-sm-4'>
                    <a href="{{route('especialidade.index')}}" class="btn btn-danger btn-block"><b>Cancelar / Voltar</b></a>
                </div>
                <div class='col-sm-8'>
                    <button type="submit" class="btn btn-success btn-block"><b>Confirmar / Salvar</b></button>
                </div>
            </div>
        </div>
    </form>

@endsection
