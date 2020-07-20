 <!-- https://material.io/resources/icons/?icon=delete&style=baseline -->

@extends('templates.main', ['titulo' => "Clientes", 'tag' => "CLI"])

@section('titulo') Clientes @endsection

@section('conteudo')

    <div class='row'>
        <div class='col-sm-6'>
            <button class="btn btn-primary btn-block" onClick="criar()">
                <b>Cadastrar Novo Cliente</b>
            </button>
        </div>
        <div class='col-sm-5' style="text-align: center">
            <input type="text" list="clientes" class="form-control"  autocomplete="on" placeholder="buscar">
            <datalist id="clientes">
                @foreach ($clientes as $item)
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
    <x-tablelist :header="['NOME', 'EVENTOS']" :data="$clientes" :tipo="1" />

{{---------------------------------------------------------------------------}}

    <div class="modal" tabindex="-1" role="dialog" id="modalCliente">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formCliente">
                    <div class="modal-header">
                    <h5 class="modal-title"><b>Cadastrar Cliente</b></h5>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" id="id" class="form-control">

                        <div class='col-sm-12'>
                            <label><b>Nome</b></label>
                            <input type="text" class="form-control" name="nome" id="nome" required>
                        </div>
                        <div class='col-sm-12'>
                            <label>E-mail</label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="col-sm-12">
                            <label>Telefone</label>
                            <input type="telefone" class="form-control" name="telefone" id="telefone">
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
                    <h5 class="modal-title"><b>Remover Cliente</b></h5>
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
            $('#modalCliente').modal().find('.modal-title').text("Cadastrar Cliente");
            $("#id").val('');
            $("#nome").val('');
            $("#email").val('');
            $("#telefone").val('');
            $('#modalCliente').modal('show');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $("#formCliente").submit(function (event) {
            event.preventDefault();
            if ($("#id").val() != ''){
                update($("#id").val());
            }
            else {
                insert();
            }
            $("#modalCliente").modal('hide');
        });

        function insert() {
            cliente = {
                nome: $("#nome").val(),
                email: $("#email").val(),
                telefone: $("#telefone").val()
            };

            $.post("/api/cliente", cliente, function (data) {
                novoCliente = JSON.parse(data);
                linha = getLin(novoCliente);
                $('#tabela>tbody').append(linha);
            });
        }

        function editar(id) {
            $('#modalCliente').modal().find('.modal-title').text("Alterar Cliente");
            $.getJSON('/api/cliente/'+id, function (data) {
                $('#id').val(data.id);
                $('#nome').val(data.nome);
                $('#email').val(data.email);
                $('#telefone').val(data.telefone);
                $('#modalCliente').modal('show');

            })
        }

        function update(id) {
            cliente = {
                nome: $("#nome").val(),
                email: $("#email").val(),
                telefone: $("#telefone").val()
            };
            $.ajax({
                type: "PUT",
                url: "/api/cliente/" + id,
                context: this,
                data: cliente,
                success: function (data) {
                    linhas = $("#tabela>tbody>tr");
                    e = linhas.filter(function (i, e) {
                        return e.cells[0].textContent == id;
                    });
                    if (e){
                        e[0].cells[1].textContent = cliente.nome;
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
            $('#modalRemove').modal().find('.modal-body').append("Deseja Remover o Cliente '" + nome + "'?");
            $('#id_remove').val(id);
            $('#modalRemove').modal('show');
        }

        function remove() {
            var id = $('#id_remove').val();
            $.ajax({
                type: "DELETE",
                url: "/api/cliente/" + id,
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

        function getLin(cliente) {
            var linha =
            "<tr style='text-align: center'>" +
                "<td>" + cliente.nome + "</td>" +
                "<td>" +
                   "<a nohref style='cursor:pointer' onclick='visualizar(" + cliente.id + ")'><img class='small' src='{{ asset('img/icons/info.svg') }}'></a>" +
                    "<a nohref style='cursor:pointer' onclick='editar(" + cliente.id + ")'><img class='small' src='{{ asset('img/icons/edit.svg') }}'></a>" +
                    "<a nohref style='cursor:pointer' onclick='remover(" + cliente.id + ", " + cliente.nome + ")'><img class='small' src='{{ asset('img/icons/delete.svg') }}'></a>" +
                "</td>" +
            "</tr>";
            return linha;
        }
    </script>
@endsection



