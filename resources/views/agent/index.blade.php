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
                    <button type="button" class="btn btn-default" type="button" onclick="nuevoAgente()"><i class="fa fa-plus"></i> Nuevo Agente</button>
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
                                    <button class="btn btn-info " type="button"><i class="fa fa-check"></i></button>
                                    <button class="btn btn-warning " type="button"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger " type="button"><i class="fa fa-trash"></i></button>
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

            $.post("{{ Route('saveAgent') }}", {code:code, name: name, lastname: lastname, dni: dni, email: email, area_id: area_id, _token: '{{ csrf_token() }}'}).done(function(data) {
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

    </script>
@endsection
