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
                              <th>Cantidad de Agentes</th>
                              <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($areas as $area)
                            <tr @if($area->status == 0) class="table-danger" @endif>
                                <td>{{ $area->id }}</td>
                                <td>{{ $area->name }}</td>
                                <td>{{ $area->description }}</td>
                                <td>{{ $area->agents->count() }}</td>
                                <td>
                                    @can('Estado Area')
                                        @if ($area->status == 0)
                                            <button class="btn btn-info " type="button" onclick="cambiarEstado('{{ $area->id }}', '{{ $area->name }}', '1')"><i class="fa fa-check"></i></button>
                                        @else
                                            <button class="btn btn-danger " type="button" onclick="cambiarEstado('{{ $area->id }}', '{{ $area->name }}', '0')"><i class="fa fa-minus"></i></button>
                                        @endif
                                    @endcan
                                    @can('Editar Area')
                                    <button class="btn btn-warning " type="button" onclick="editarArea('{{ $area->id }}', '{{ $area->name }}', '{{ $area->description }}')"><i class="fa fa-pencil"></i></button>
                                    @endcan
                                    @can('Eliminar Area')
                                    <button class="btn btn-danger " type="button" onclick="eliminarArea('{{ $area->id }}', '{{ $area->name }}')"><i class="fa fa-trash"></i></button>
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

<div class="modal inmodal fade" id="modalEditArea" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Área</h4>
                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Id Área" id='eId' hidden>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Nombre</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su área" id='eName'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Descripción</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese una descripción" id='eDescription'>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="updateArea()"><i class="fa fa-save"></i> Guardar</button>
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

        function editarArea(id, name, description) {
            $("#eId").val(id);
            $("#eName").val(name);
            $("#eDescription").val(description);

            $('#modalEditArea').modal('show');
        }

        function updateArea() {
            var id = $("#eId").val();
            var name = $("#eName").val();
            var description = $("#eDescription").val();

            $.post("{{ Route('updateArea') }}", {id: id, name: name, description: description, _token: '{{ csrf_token() }}'}).done(function(data) {
                $('#modalEditArea').modal('hide');
                $("#tabArea").empty();
                $("#tabArea").html(data.view);
                if (data.resp == 1) {
                    Swal.fire({
                        title: "Editar",
                        text: "El área fué editado correctamente",
                        icon: "success"
                    });
                } else {
                    Swal.fire({
                        title: "Editar",
                        text: "El área no pudo ser editado",
                        icon: "error"
                    });
                }
            });
        }

        function cambiarEstado(id, name, status) {
            Swal.fire({
                title: "¿Desea cambiar el estado de esta área?",
                text: "Área: " + name,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, cambiar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.post("{{ Route('changeStatusArea') }}", {id: id, status: status, _token: '{{ csrf_token() }}'}).done(function(data) {
                        $("#tabArea").empty();
                        $("#tabArea").html(data.view);
                        if (data.resp == 1) {
                            Swal.fire({
                                title: "Estado",
                                text: "El estado del área se modificó correctamente",
                                icon: "success"
                            });

                        } else {

                            Swal.fire({
                                title: "Guardado",
                                text: "No se pudo cambiar el estado del área",
                                icon: "error"
                            });
                        }
                    });

                }
            });
        }

        function eliminarArea(id, name) {
            Swal.fire({
                title: "¿Desea eliminar esta área?",
                text: "Área: " + name,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, cambiar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.post("{{ Route('deleteArea') }}", {id: id, _token: '{{ csrf_token() }}'}).done(function(data) {
                        $("#tabArea").empty();
                        $("#tabArea").html(data.view);
                        if (data.resp == 1) {
                            Swal.fire({
                                title: "Estado",
                                text: "El estado del área se modificó correctamente",
                                icon: "success"
                            });

                        } else {

                            Swal.fire({
                                title: "Guardado",
                                text: "No se pudo cambiar el estado del área",
                                icon: "error"
                            });
                        }
                    });

                }
            });
        }

    </script>
@endsection
