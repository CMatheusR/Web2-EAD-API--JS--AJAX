@extends('templates.main', ['titulo' => "Cadastrar Veterinario", 'tag' => "VET"])

@section('titulo') Novo Veterinário @endsection

@section('conteudo')

    <form action="{{ route('veterinario.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <div class='col-sm-16'>
                <label>Nome</label>
                <input type="text" class="form-control {{$errors->has('nome') ? 'is-invalid' : ''}}" name="nome" value="{{old('nome')}}"/>
                @if($errors->has('nome'))
                    <div class="invalid-feedback">
                        {{$errors->first('nome')}}
                    </div>
                @endif
            </div>
            <div class="row">
                <div class='col-sm-6'>
                    <label>CRMV</label>
                    <input class="form-control {{$errors->has('crmv') ? 'is-invalid' : ''}}" name="crmv" value="{{old('crmv')}}"/>
                    @if($errors->has('crmv'))
                        <div class="invalid-feedback">
                            {{$errors->first('crmv')}}
                        </div>
                    @endif
                </div>
                <div class="col-sm-6">
                    <label>Especialidade</label>
                    <select class="form-control {{$errors->has('especialidade_id') ? 'is-invalid' : ''}}" name="especialidade_id" >,
                        <option value=""></option>
                        @foreach($dados as $espec)
                            @if($espec['id'] == old('especialidade_id'))
                                <option value="{{$espec->id}}" selected>{{$espec->nome}}</option>
                            @else
                                <option value="{{$espec->id}}">{{$espec->nome}}</option>
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
