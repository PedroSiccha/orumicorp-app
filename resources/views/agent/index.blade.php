@extends('layouts.app')

@section('title')
      Agentes
@endsection

@section('content')
<div class="row">
      <div class="col-lg-12">
          <div class="ibox ">
              <div class="ibox-title d-flex justify-content-between align-items-center">
                  <h5>Tabla de Agentes </h5>
                  @if (auth()->check() && auth()->user()->hasRole('ADMINISTRADOR'))
                    <div class="col-sm-2 text-right">
                        @can('Filtrar Area Today')
                            <select class="form-control m-b" name="area" id="area" onchange="filterAgent('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabAgente')" onclick="filterAgent('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabAgente')">
                                @foreach($areas as $area)
                                <option value = "{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        @endcan
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Buscar por nombre o código" id="inputCode" oninput="filterAgent('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabAgente')">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-default" type="button"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    @endif

                  <div class="col-sm-2 text-right">
                    @can('Crear Agente')
                        <button type="button" class="btn btn-default" type="button" onclick="mostrarNuevoModal('#modalAgente')"><i class="fa fa-plus"></i> Nuevo Agente</button>
                    @endcan
                  </div>
              </div>
              <div class="ibox-content" id="tabAgente">
                @include('agent.list.listAgent')
              </div>
          </div>
      </div>
  </div>

  @include('agent.modal.modalSaveAgent')

<div class="modal inmodal fade" id="modalEditAgente" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Agente</h4>
                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su código" id='eId' hidden>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Código</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su código" id='eCode'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Nombre</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su nombre" id='eName'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Apellidos</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su apellido" id='eLastname'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Código Voiso</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Registro Código Voiso" id='ecodeVoiso'>
                            </td>
                        </tr>
                        <tr>
                              <td>
                                    <strong>Área</strong>
                              </td>
                              <td>
                                    <select class="form-control m-b" name="account" id="eArea_id">
                                          <option>Seleccione su Área</option>
                                          @foreach($areas as $area)
                                          <option value = "{{ $area->id }}">{{ $area->name }}</option>
                                          @endforeach
                                      </select>
                              </td>
                        </tr>
                        <tr>
                            <td>
                                  <strong>Asignar un Rol</strong>
                            </td>
                            <td>
                                  <select class="form-control m-b" name="account" id="eRol_id">
                                        <option>Seleccione su Rol</option>
                                        @foreach($roles as $rol)
                                        <option value = "{{ $rol->id }}">{{ $rol->name }}</option>
                                        @endforeach
                                    </select>
                            </td>
                      </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="updateAgente()"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="modalCantGiros" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Registrar Cantidad de Giros</h4>
                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su código" id='cantId' hidden>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Agente</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Nombres del agente" id='cantName' readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Cantidad de Giros</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='number' class='form-control text-success' placeholder="Ingrese la cantidad de giros" id='cantGiros'>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="registerCant()"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/agent/filterAgent.js') }}"></script>
<script src="{{ asset('js/agent/agent.js') }}"></script>

    <script>

    $(document).ready(function() {
            $('#date_added_init').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
            });
            $('#date_added_end').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
            });
        });

        var filterAgentRoute = '{{ route("filterAgent") }}';
        var saveAgentRoute = '{{ route("saveAgent") }}';
        var token = '{{ csrf_token() }}';

        function asignarCantGiros(id, name) {
            $("#cantId").val(id);
            $("#cantName").val(name);
            $('#modalCantGiros').modal('show');
        }

        function registerCant() {
            var id = $("#cantId").val();
            var cant = $("#cantGiros").val();
            $.post("{{ Route('saveNumberTurns') }}", {id: id, cant: cant, _token: '{{ csrf_token() }}'}).done(function(data) {
                $('#modalCantGiros').modal('hide');
                $("#tabAgente").empty();
                $("#tabAgente").html(data.view);
                if (data.resp == 1) {

                    Swal.fire({
                        title: "Guardado",
                        text: "Se registraron sus giros correctamente",
                        icon: "success"
                    });

                } else {

                    Swal.fire({
                        title: "Guardado",
                        text: "El agente no pudo ser guardado",
                        icon: "error"
                    });

                }

            });
        }






        function editarAgente(id, code, name, lastname, codeVoiso, email, area_id, roles) {
            $("#eId").val(id);
            $("#eCode").val(code);
            $("#eName").val(name);
            $("#eLastname").val(lastname);
            $("#ecodeVoiso").val(codeVoiso);
            $("#eEmail").val(email);
            $("#eArea_id").val(area_id);
            // var data = {roles};

            $("#eRol_id").val(roles);

            $('#modalEditAgente').modal('show');
        }

        function updateAgente() {
            var id = $("#eId").val();
            var code = $("#eCode").val();
            var name = $("#eName").val();
            var lastname = $("#eLastname").val();
            var codeVoiso = $("#ecodeVoiso").val();
            var email = $("#eEmail").val();
            var area_id = $("#eArea_id").val();
            var rol_id = $("#eRol_id").val();

            $.post("{{ Route('updateAgent') }}", {id: id, code: code, name: name, lastname: lastname, codeVoiso: codeVoiso, email: email, area_id: area_id, rol_id: rol_id, _token: '{{ csrf_token() }}'}).done(function(data) {
                $('#modalEditAgente').modal('hide');
                $("#tabAgente").empty();
                $("#tabAgente").html(data.view);
                if (data.resp == 1) {
                    Swal.fire({
                        title: "Editar",
                        text: "El agente fué editado correctamente",
                        icon: "success"
                    });
                } else {
                    Swal.fire({
                        title: "Editar",
                        text: "El agente no pudo ser editado",
                        icon: "error"
                    });
                }
            });
        }

        function cambiarEstado(id, name, status) {
            Swal.fire({
                title: "¿Desea cambiar el estado de este agente?",
                text: "Agente :" + name,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, cambiar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.post("{{ Route('cambiarEstadoAgente') }}", {id: id, status: status, _token: '{{ csrf_token() }}'}).done(function(data) {
                        $("#tabAgente").empty();
                        $("#tabAgente").html(data.view);
                        if (data.resp == 1) {
                            Swal.fire({
                                title: "Estado",
                                text: "El estado del agente se modificó correctamente",
                                icon: "success"
                            });

                        } else {

                            Swal.fire({
                                title: "Guardado",
                                text: "No se pudo cambiar el estado del agente",
                                icon: "error"
                            });
                        }
                    });

                }
            });
        }

        function eliminarAgente(id, name) {
            Swal.fire({
                title: "¿Desea eliminar a este agente?",
                text: "Agente :" + name,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, cambiar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.post("{{ Route('eliminarAgente') }}", {id: id, _token: '{{ csrf_token() }}'}).done(function(data) {
                        $("#tabAgente").empty();
                        $("#tabAgente").html(data.view);
                        if (data.resp == 1) {
                            Swal.fire({
                                title: "Estado",
                                text: "El estado del agente se modificó correctamente",
                                icon: "success"
                            });

                        } else {

                            Swal.fire({
                                title: "Guardado",
                                text: "No se pudo cambiar el estado del agente",
                                icon: "error"
                            });
                        }
                    });

                }
            });
        }

    </script>

<script>
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

    function fetch_data(page) {
        $.ajax({
            url: "/agentsPagination?page=" + page,
            success: function(data) {
                $('#tabAgente').html(data);
            }
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        markNotificationsAsSeen('agents');
    });
</script>
@endsection
