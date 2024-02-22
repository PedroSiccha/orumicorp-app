@extends('layouts.app')

@section('title')
      Áreas
@endsection

@section('content')
<div class="row">
      <div class="col-lg-12">
          <div class="ibox ">
              <div class="ibox-title d-flex justify-content-between align-items-center">
                  <h5>Tabla Áreas </h5>
                  <div>
                    @can('Crear Area')
                    <button type="button" class="btn btn-default" type="button" onclick="nuevaArea()"><i class="fa fa-plus"></i> Nueva Área</button>
                    @endcan
                  </div>
              </div>
              <div class="ibox-content" id="tabArea">
                  <table class="table table-striped">
                      <thead>
                        <tr>
                              <th>ID de Área</th>
                              <th>Nombre del Área</th>
                              <th>Descripción</th>
                              <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($areas as $area)
                            <tr>
                                <td>{{ $area->id }}</td>
                                <td>{{ $area->name }}</td>
                                <td>{{ $area->description }}</td>
                                <td>
                                    @can('Estado Area')
                                    <button class="btn btn-info " type="button"><i class="fa fa-check"></i></button>
                                    @endcan
                                    @can('Editar Area')
                                    <button class="btn btn-warning " type="button"><i class="fa fa-pencil"></i></button>
                                    @endcan
                                    @can('Eliminar Area')
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

  <div class="modal inmodal fade" id="modalArea" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nueva Área</h4>
                <small class="font-bold">Registre su nueva área</small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Nombre</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su área" id='name'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Descripción</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese una descripción" id='description'>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="guardarNuevaArea()"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

    <script>

        function nuevaArea() {
            $('#modalArea').modal('show');
        }

        function guardarNuevaArea() {
            var name = $("#name").val();
            var description = $("#description").val();

            $.post("{{ Route('saveArea') }}", {name: name, description: description, _token: '{{ csrf_token() }}'}).done(function(data) {
                $('#modalArea').modal('hide');
                $("#tabArea").empty();
                $("#tabArea").html(data.view);
                if (data.resp == 1) {

                    Swal.fire({
                        title: "Correcto",
                        text: "El área se guardó correctamente",
                        icon: "success"
                    });

                } else {

                    Swal.fire({
                        title: "Error",
                        text: "El área no pudo ser guardada",
                        icon: "error"
                    });

                }

            });

        }

    </script>
@endsection
