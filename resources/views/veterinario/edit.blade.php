@extends('templates.main', ['titulo' => "Alterar Veterinario", 'tag' => "ESP"])

@section('titulo') {{$dados['nome']}} @endsection

@section('conteudo')

    <form action="{{ route('veterinario.update', $dados['id']) }}" method="POST">
    @csrf
        @method('PUT')
        <div class="form-group">
            <div class='col-sm-16'>
                <label>Nome</label>
                <input type="text" class="form-control {{$errors->has('nome') ? 'is-invalid' : ''}}" name="nome" value="{{$dados['nome']}}"/>
                @if($errors->has('nome'))
                    <div class="invalid-feedback">
                        {{$errors->first('nome')}}
                    </div>
                @endif
            </div>
            <div class="row">
                <div class='col-sm-6'>
                    <label>CRMV</label>
                    <input class="form-control {{$errors->has('crmv') ? 'is-invalid' : ''}}" name="crmv" value="{{$dados['crmv']}}"/>
                    @if($errors->has('crmv'))
                        <div class="invalid-feedback">
                            {{$errors->first('crmv')}}
                        </div>
                    @endif
                </div>
                <div class="col-sm-6">
                    <label>Especialidade</label>
                    <select class="form-control" name="especialidade_id">
                        @foreach($espec as $aux)
                            @if($aux['id'] == $dados['especialidade_id'])
                                <option value="{{$aux['id']}}" selected>{{$aux['nome']}}</option>
                            @else
                                <option value="{{$aux['id']}}">{{$aux['nome']}}</option>
                            @endif
                        @endforeach
                    </select>
                    @if($errors->has('especialidade_id'))
                        <div class="invalid-feedback">
                            {{$errors->first('especialidade_id')}}
                        </div>
                    @endif
                </div>
            </div>
            <div class='row' style="margin-top:20px">
                <div class='col-sm-4'>
                    <a href="{{route('veterinario.index')}}" class="btn btn-danger btn-block"><b>Cancelar / Voltar</b></a>
                </div>
                <div class='col-sm-8'>
                    <button type="submit" class="btn btn-success btn-block"><b>Confirmar / Salvar</b></button>
                </div>
            </div>
        </div>
    </form>

@endsection
