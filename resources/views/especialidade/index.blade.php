 <!-- https://material.io/resources/icons/?icon=delete&style=baseline -->

@extends('templates.main', ['titulo' => "Especialidade", 'tag' => "ESP"])

@section('titulo') Especialidade @endsection

@section('conteudo')

    <div class='row'>
        <div class='col-sm-6'>
            <button class="btn btn-primary btn-block" onclick="criar()">
                <b>Cadastrar Nova Especialidade</b>
            </button>
        </div>
        <div class='col-sm-5' style="text-align: center">
            <input type="text" list="clientes" class="form-control"  autocomplete="on" placeholder="buscar">
            <datalist id="clientes">
                @foreach ($especialidades as $item)
                    <option value="{{ $item['nome'] }}">
                @endforeach
            </datalist>
        </div>
        <div class='col-sm-1' style="text-align: center">
            <button type="button" class="btn btn-default btn-block">
                <img class="small" src="{{ asset('img/icons/search.svg') }}">
            </button>
        </div>
    </div>
    <br>
    <x-tablelist :header="['NOME', 'EVENTOS']" :data="$especialidades" :tipo="3" />

{{---------------------------------------------------------------------------------}}

    <div class="modal" tabindex="-1" role="dialog" id="modalEspecialidade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formEspecialidade">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Cadastrar Especialidade</b></h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control">

                        <div class='col-sm-12'>
                            <label><b>Nome</b></label>
                            <input type="text" class="form-control" name="nome" id="nome" required>
                        </div>
                        <div class='col-sm-12'>
                            <label><b>Descrição</b></label>
                            <textarea class="form-control" name="descricao" id="descricao" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >Salvar</button>
                        <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{---------------------------------------------------------------------------------}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalRemove">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <input type="hidden" id="id_remove" class="form-control">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Remover Especialidade</b></h5>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button class="btn btn-danger" onclick="remove()" >Sim, remover!</button>
                    <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Não, cancelar!</button>
                </div>
            </div>
        </div>
    </div>

@endsection


 @section('script')
     <script type="text/javascript">
         function criar() {
             $('#modalEspecialidade').modal().find('.modal-title').text("Cadastrar Especialidade");
             $("#id").val('');
             $("#nome").val('');
             $("#descricao").val('');
             $('#modalCliente').modal('show');
         }

         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
             }
         });

         $("#formEspecialidade").submit(function (event) {
             event.preventDefault();
             if ($("#id").val() != ''){
                 update($("#id").val());
             }
             else {
                 insert();
             }
             $("#modalEspecialidade").modal('hide');
         });

         function insert() {
             especialidade = {
                 nome: $("#nome").val(),
                 descricao: $("#descricao").val()
             };

             $.post("/api/especialidade", especialidade, function (data) {
                 novaEspecialidade = JSON.parse(data);
                 linha = getLin(novaEspecialidade);
                 $('#tabela>tbody').append(linha);
             });
         }

         function editar(id) {
             $('#modalEspecialidade').modal().find('.modal-title').text("Alterar Especialidade");
             $.getJSON('/api/especialidade/'+id, function (data) {
                 $('#id').val(data.id);
                 $('#nome').val(data.nome);
                 $('#descricao').val(data.descricao);
                 $('#modalEspecialidade').modal('show');

             })
         }

         function update(id) {
             especialidade = {
                 nome: $("#nome").val(),
                 descricao: $("#descricao").val()
             };
             $.ajax({
                 type: "PUT",
                 url: "/api/especialidade/" + id,
                 context: this,
                 data: especialidade,
                 success: function (data) {
                     linhas = $("#tabela>tbody>tr");
                     e = linhas.filter(function (i, e) {
                         return e.cells[0].textContent == id;
                     });
                     if (e){
                         e[0].cells[1].textContent = especialidade.nome;
                     }
                 },
                 error: function (error) {
                     alert('ERRO - UPDATE');
                     console.log(error);
                 }
             });
         }

         function visualizar() {alert('show')}

         function remover(id, nome) {
             $('#modalRemove').modal().find('.modal-body').html("");
             $('#modalRemove').modal().find('.modal-body').append("Deseja Remover a Especialidade '" + nome + "'?");
             $('#id_remove').val(id);
             $('#modalRemove').modal('show');
         }

         function remove() {
             var id = $('#id_remove').val();
             $.ajax({
                 type: "DELETE",
                 url: "/api/especialidade/" + id,
                 context: this,
                 success: function () {
                     linhas = $("#tabela>tbody>tr");
                     e = linhas.filter(function (i, elemento) {
                         return elemento.cells[0].textContent == id;
                     });
                     if(e){
                         e.remove();
                     }
                 },
                 error: function (error) {
                     alert('ERRO - DELETE');
                     console.log(error);
                 }
             });
             $('#modalRemove').modal('hide');
         }

         function getLin(especialidade) {
             var linha =
                 "<tr style='text-align: center'>" +
                 "<td>" + especialidade.nome + "</td>" +
                 "<td>" +
                 "<a nohref style='cursor:pointer' onclick='visualizar(" + especialidade.id + ")'><img class='small' src='{{ asset('img/icons/info.svg') }}'></a>" +
                 "<a nohref style='cursor:pointer' onclick='editar(" + especialidade.id + ")'><img class='small' src='{{ asset('img/icons/edit.svg') }}'></a>" +
                 "<a nohref style='cursor:pointer' onclick='remover(" + especialidade.id + ", " + especialidade.nome + ")'><img class='small' src='{{ asset('img/icons/delete.svg') }}'></a>" +
                 "</td>" +
                 "</tr>";
             return linha;
         }
     </script>
 @endsection




