

@extends('templates.main', ['titulo' => "Alterar Cliente", 'tag' => "CLI"])

@section('titulo') {{$dados['nome']}} @endsection

@section('conteudo')

    <form action="{{ route('cliente.update', $dados['id']) }}" method="POST">
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
            <div class='row'>
                <div class='col-sm-6'>
                    <label>E-mail</label>
                    <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" name="email" value="{{$dados['email']}}">
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{$errors->first('email')}}
                        </div>
                    @endif
                </div>
                <div class="col-sm-6">
                    <label>Telefone</label>
                    <input type="telefone" class="form-control {{$errors->has('telefone') ? 'is-invalid' : ''}}" name="telefone" value="{{$dados['telefone']}}">
                    @if($errors->has('telefone'))
                        <div class="invalid-feedback">
                            {{$errors->first('telefone')}}
                        </div>
                    @endif
                </div>
            </div>
            <div class='row' style="margin-top:20px">
                <div class='col-sm-4'>
                    <a href="{{route('cliente.index')}}" class="btn btn-danger btn-block"><b>Cancelar / Voltar</b></a>
                </div>
                <div class='col-sm-8'>
                    <button type="submit" class="btn btn-success btn-block"><b>Confirmar / Salvar</b></button>
                </div>
            </div>
        </div>
    </form>

@endsection
