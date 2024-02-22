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
                    @can('Crear Cliente')
                    <button type="button" class="btn btn-default" type="button" onclick="nuevoCliente()"><i class="fa fa-plus"></i> Nuevo Cliente</button>
                    @endcan
                  </div>
              </div>
              <div class="ibox-content" id="tabClient">
                  <table class="table table-striped">
                      <thead>
                      <tr>
                          <th>Fecha de Ingreso</th>
                          <th>ID de Cliente</th>
                          <th>Nombre del Cliente</th>
                          <th>Acción</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{  date("d/m/Y", strtotime($customer->date_admission)) }}</td>
                                <td>{{ $customer->code }}</td>
                                <td>{{ $customer->name }} {{ $customer->lastname }}</td>
                                <td>
                                    @can('Estado Cliente')
                                    <button class="btn btn-info " type="button"><i class="fa fa-check"></i></button>
                                    @endcan
                                    @can('Editar Cliente')
                                    <button class="btn btn-warning " type="button"><i class="fa fa-pencil"></i></button>
                                    @endcan
                                    @can('Eliminar Cliente')
                                    <button class="btn btn-danger " type="button"><i class="fa fa-trash"></i></button>
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

  <div class="modal inmodal fade" id="modalCliente" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nuevo Cliente</h4>
                <small class="font-bold">Registre su nuevo cliente</small>
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
                <button class="btn btn-info " type="button" onclick="guardarNuevoCliente()"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

    <script>

        function nuevoCliente() {
            $('#modalCliente').modal('show');
        }

        function guardarNuevoCliente() {
            var name = $("#name").val();
            var lastname = $("#lastname").val();
            var dni = $("#dni").val();
            var email = $("#email").val();
            var code = $("#code").val();
            var rol_id = $("#rol_id").val();

            $.post("{{ Route('saveCustomer') }}", {code: code, name: name, lastname: lastname, dni: dni, email: email, rol_id: rol_id, _token: '{{ csrf_token() }}'}).done(function(data) {
                $('#modalCliente').modal('hide');
                $("#tabClient").empty();
                $("#tabClient").html(data.view);
                if (data.resp == 1) {

                    Swal.fire({
                        title: "Guardado",
                        text: "El cliente se guardó correctamente",
                        icon: "success"
                    });

                } else {

                    Swal.fire({
                        title: "Guardado",
                        text: "El cliente se guardó correctamente",
                        icon: "error"
                    });

                }

            });

        }

    </script>
@endsection
