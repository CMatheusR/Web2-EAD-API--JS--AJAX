@extends('templates.main', ['titulo' => "Cadastrar Especialidade", 'tag' => "ESP"])

@section('titulo') Nova Especialidade @endsection

@section('conteudo')

    <form action="{{ route('especialidade.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <div class="row">
                <div class='col-sm-12'>
                    <label>Nome</label>
                    <input type="text" class="form-control {{$errors->has('nome') ? 'is-invalid' : ''}}" name="nome" value="{{old('nome')}}"/>
                    @if($errors->has('nome'))
                        <div class="invalid-feedback">
                            {{$errors->first('nome')}}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class='col-sm-12'>
                    <label>Descrição</label>
                    <textarea class="form-control {{$errors->has('descricao') ? 'is-invalid' : ''}}" name="descricao" >{{old('descricao')}}</textarea>
                    @if($errors->has('descricao'))
                        <div class="invalid-feedback">
                            {{$errors->first('descricao')}}
                        </div>
                    @endif
                </div>
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
