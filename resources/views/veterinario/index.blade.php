 <!-- https://material.io/resources/icons/?icon=delete&style=baseline -->

@extends('templates.main', ['titulo' => "Veterinario", 'tag' => "VET"])

@section('titulo') Veterinários @endsection

@section('conteudo')

    <div class='row'>
        <div class='col-sm-6'>
            <button class="btn btn-primary btn-block" onclick="criar()">
                <b>Cadastrar Novo Veterinário</b>
            </a>
        </div>
        <div class='col-sm-5' style="text-align: center">
            <input type="text" list="clientes" class="form-control"  autocomplete="on" placeholder="buscar">
            <datalist id="clientes">
                @foreach ($veterinarios as $item)
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
    <x-tablelist :header="['NOME', 'EVENTOS']" :data="$veterinarios" :tipo="2" />

    {{---------------------------------------------------------------------------}}

    <div class="modal" tabindex="-1" role="dialog" id="modalVeterinario">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formVeterinario">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Cadastrar Veterinario</b></h5>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" id="id" class="form-control">

                        <div class='col-sm-12'>
                            <label><b>Nome</b></label>
                            <input type="text" class="form-control" name="nome" id="nome" required>
                        </div>
                        <div class='col-sm-12'>
                            <label>CRMV</label>
                            <input class="form-control" name="crmv" id="crmv">
                        </div>
                        <div class="col-sm-12">
                            <label>Especialidade</label>
                            <select class="form-control" name="especialidade_id" id="especialidade_id"></select>
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
    {{---------------------------------------------------------------------------}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalRemove">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <input type="hidden" id="id_remove" class="form-control">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Remover Veterinario</b></h5>
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
             $('#modalVeterinario').modal().find('.modal-title').text("Cadastrar Veterinario");
             carregarEspecialidade();
             $("#id").val('');
             $("#crmv").val('');
             $("#especialidade_id").val('');
             $('#modalVeterinario').modal('show');
         }

         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
             }
         });

         function carregarEspecialidade(id){
             $.getJSON('/api/especialidade/load', function (data) {
                $('#especialidade_id').html("");
                for (let i=0; i < data.length; i++){
                    if(data[i].id == id){
                        item = '<option value="' + data[i].id + '"selected>' + data[i].nome + '</option>';
                    }else{
                        item = '<option value="' + data[i].id + '">' + data[i].nome + '</option>';
                    }
                    $('#especialidade_id').append(item);
                }
             });
         }

         $("#formVeterinario").submit(function (event) {
             event.preventDefault();
             if ($("#id").val() != ''){
                 update($("#id").val());
             }
             else {
                 insert();
             }
             $("#modalVeterinario").modal('hide');
         });

         function insert() {
             veterinario = {
                 nome: $("#nome").val(),
                 crmv: $("#crmv").val(),
                 especialidade_id: $("#especialidade_id").val()
             };

             $.post("/api/veterinario", veterinario, function (data) {
                 novoVeterinario = JSON.parse(data);
                 linha = getLin(novoVeterinario);
                 $('#tabela>tbody').append(linha);
             });
         }

         function editar(id) {
             $('#modalVeterinario').modal().find('.modal-title').text("Alterar Veterinario");
             $.getJSON('/api/veterinario/'+id, function (data) {

                 $('#id').val(data.id);
                 $('#nome').val(data.nome);
                 $('#crmv').val(data.crmv);
                 $('#especialidade_id').val(data.especialidade_id);
                 carregarEspecialidade(data.id);
                 $('#modalVeterinario').modal('show');

             })
         }

         function update(id) {
             veterinario = {
                 nome: $("#nome").val(),
                 crmv: $("#crmv").val(),
                 especialidade_id: $("#especialidade_id").val()
             };
             $.ajax({
                 type: "PUT",
                 url: "/api/veterinario/" + id,
                 context: this,
                 data: veterinario,
                 success: function (data) {
                     linhas = $("#tabela>tbody>tr");
                     e = linhas.filter(function (i, e) {
                         return e.cells[0].textContent == id;
                     });
                     if (e){
                         e[0].cells[1].textContent = veterinario.nome;
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
             $('#modalRemove').modal().find('.modal-body').append("Deseja Remover o veterinario '" + nome + "'?");
             $('#id_remove').val(id);
             $('#modalRemove').modal('show');
         }

         function remove() {
             var id = $('#id_remove').val();
             $.ajax({
                 type: "DELETE",
                 url: "/api/veterinario/" + id,
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

         function getLin(veterinario) {
             var linha =
                 "<tr style='text-align: center'>" +
                 "<td>" + veterinario.nome + "</td>" +
                 "<td>" +
                 "<a nohref style='cursor:pointer' onclick='visualizar(" + veterinario.id + ")'><img class='small' src='{{ asset('img/icons/info.svg') }}'></a>" +
                 "<a nohref style='cursor:pointer' onclick='editar(" + veterinario.id + ")'><img class='small' src='{{ asset('img/icons/edit.svg') }}'></a>" +
                 "<a nohref style='cursor:pointer' onclick='remover(" + veterinario.id + ", " + veterinario.nome + ")'><img class='small' src='{{ asset('img/icons/delete.svg') }}'></a>" +
                 "</td>" +
                 "</tr>";
             return linha;
         }
     </script>
 @endsection


