@extends('layouts.app')

@section('title')
      Clientes
@endsection

@section('content')
<div class="row">
      <div class="col-lg-12">
          <div class="ibox ">
              <div class="ibox-title d-flex justify-content-between align-items-center">
                  <h5>Tabla Clientes </h5>
                  <div>
                    @can('Crear Agente')
                    <button type="button" class="btn btn-default" type="button" onclick="nuevoAgente()"><i class="fa fa-plus"></i> Nuevo Agente</button>
                    @endcan
                  </div>
              </div>
              <div class="ibox-content" id="tabAgente">
                  <table class="table table-striped">
                      <thead>
                        <tr>
                              <th>ID de Agente</th>
                              <th>Nombre del Agente</th>
                              <th>DNI</th>
                              <th>Área</th>
                              <th>Correo</th>
                              <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($agents as $agent)
                            <tr>
                                <td>{{ $agent->code }}</td>
                                <td>{{ $agent->name }} {{ $agent->lastname }}</td>
                                <td>{{ $agent->dni }}</td>
                                <td>{{ $agent->area->name }}</td>
                                <td>{{ $agent->user->email }}</td>
                                <td>
                                    @can('Estado Agente')
                                    <button class="btn btn-info " type="button" onclick="cambiarEstado('{{ $agent->id }}', '{{ $agent->name }} {{ $agent->lastname }}')"><i class="fa fa-check"></i></button>
                                    @endcan
                                    @can('Editar Agente')
                                    <button class="btn btn-warning " type="button" onclick="editarAgente('{{ $agent->id }}', '{{ $agent->code }}', '{{ $agent->name }}', '{{ $agent->lastname }}', '{{ $agent->dni }}', '{{ $agent->email }}', '{{ $agent->area->id }}', '{{ $agent->user->roles->first() }}')"><i class="fa fa-pencil"></i></button>
                                    @endcan
                                    @can('Eliminar Agente')
                                    <button class="btn btn-danger " type="button" onclick="eliminarAgente('{{ $agent->id }}', '{{ $agent->name }} {{ $agent->lastname }}')"><i class="fa fa-trash"></i></button>
                                    @endcan

                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>

  <div class="modal inmodal fade" id="modalAgente" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nuevo Agente</h4>
                <small class="font-bold">Registre su nuevo agente</small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Código</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su código" id='code'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Nombre</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su nombre" id='name'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Apellidos</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su apellido" id='lastname'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>DNI</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su dni" id='dni'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Correo</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='email' class='form-control text-success' placeholder="Ingrese su correo" id='email'>
                            </td>
                        </tr>
                        <tr>
                              <td>
                                    <strong>Área</strong>
                              </td>
                              <td>
                                    <select class="form-control m-b" name="account" id="area_id">
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
                                  <select class="form-control m-b" name="account" id="rol_id">
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
                <button class="btn btn-info " type="button" onclick="guardarNuevoAgente()"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

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
                                <strong>DNI</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su dni" id='eDni'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Correo</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='email' class='form-control text-success' placeholder="Ingrese su correo" id='eEmail'>
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
@endsection
@section('script')

    <script>

        function nuevoAgente() {
            $('#modalAgente').modal('show');
        }

        function guardarNuevoAgente() {
            var name = $("#name").val();
            var lastname = $("#lastname").val();
            var dni = $("#dni").val();
            var email = $("#email").val();
            var area_id = $("#area_id").val();
            var code = $("#code").val();
            var rol_id = $("#rol_id").val();

            $.post("{{ Route('saveAgent') }}", {code:code, name: name, lastname: lastname, dni: dni, email: email, area_id: area_id, rol_id: rol_id, _token: '{{ csrf_token() }}'}).done(function(data) {
                $('#modalAgente').modal('hide');
                $("#tabAgente").empty();
                $("#tabAgente").html(data.view);
                if (data.resp == 1) {

                    Swal.fire({
                        title: "Guardado",
                        text: "El agente se guardó correctamente",
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

        function editarAgente(id, code, name, lastname, dni, email, area_id, roles) {
            $("#eId").val(id);
            $("#eCode").val(code);
            $("#eName").val(name);
            $("#eLastname").val(lastname);
            $("#eDni").val(dni);
            $("#eEmail").val(email);
            $("#eArea_id").val(area_id);
            var data = {roles};

            $("#eRol_id").val(data.id);

            $('#modalEditAgente').modal('show');
        }

        function updateAgente() {
            var id = $("#eId").val();
            var code = $("#eCode").val();
            var name = $("#eName").val();
            var lastname = $("#eLastname").val();
            var dni = $("#eDni").val();
            var email = $("#eEmail").val();
            var area_id = $("#eArea_id").val();
            var rol_id = $("#eRol_id").val();

            $.post("{{ Route('updateAgent') }}", {id: id, code: code, name: name, lastname: lastname, dni: dni, email: email, area_id: area_id, rol_id: rol_id, _token: '{{ csrf_token() }}'}).done(function(data) {
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

        function cambiarEstado(id, name) {
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

                    $.post("{{ Route('cambiarEstadoAgente') }}", {id: id, _token: '{{ csrf_token() }}'}).done(function(data) {
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
@endsection
