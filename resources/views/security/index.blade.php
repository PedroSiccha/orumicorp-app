@extends('layouts.app')

@section('title')
      Panel de Seguridad
@endsection

@section('content')
<div class="row">
      <div class="col-lg-6">
          <div class="ibox ">
              <div class="ibox-title d-flex justify-content-between align-items-center">
                  <h5>Tabla de Roles </h5>
                  <div>
                    @can('Registrar Roles')
                    <button type="button" class="btn btn-default" type="button" onclick="nuevoRol()"><i class="fa fa-plus"></i> Nuevo Rol</button>
                    @endcan
                  </div>
              </div>
              <div class="ibox-content" id="tabRoles">
                  <table class="table table-striped">
                      <thead>
                        <tr>
                              <th>ID</th>
                              <th>Rol</th>
                              <th>Tipo</th>
                              <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($roles as $rol)
                            <tr onclick="verPermisos('{{ $rol->id }}')">
                                <td>{{ $rol->id }}</td>
                                <td>{{ $rol->name }}</td>
                                <td>{{ $rol->guard_name }}</td>
                                <td>
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

      <div class="col-lg-6">
        @can('Ver Permisos de Roles')
        <div class="ibox ">
            <div class="ibox-title d-flex justify-content-between align-items-center">
                <h5>Tabla de Permisos </h5>
                <div>
                    @can('Asignar Permisos')
                    <button type="button" class="btn btn-default" onclick="asignarPermiso()" style="display: none;" id="btnAsignar"><i class="fa fa-plus"></i> Asignar Permiso</button>
                    @endcan
                </div>
            </div>
            <div class="ibox-content" id="tabPermisos">
                <table class="table table-striped">
                    <thead>
                      <tr>
                            <th>ID</th>
                            <th>Permiso</th>
                            <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($permisos as $permiso)
                          <tr>
                              <td>{{ $permiso->id }}</td>
                              <td>{{ $permiso->name }}</td>
                              <td>{{ $permiso->guard_name }}</td>
                              <td>
                                  <button class="btn btn-warning " type="button"><i class="fa fa-pencil"></i></button>
                                  <button class="btn btn-danger " type="button"><i class="fa fa-trash"></i></button>
                              </td>
                          </tr>
                      @endforeach
                    </tbody>
                </table>
                <div class="pagination justify-content-center">
                    {{ $permisos->links() }}
                </div>
            </div>
        </div>
        @endcan
    </div>
  </div>

<div class="modal inmodal fade" id="modalRol" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nuevo Rol</h4>
                <small class="font-bold">Registre su nuevo rol</small>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nombre del Rol</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Ingrese el nombre del rol" class="form-control" id='name'>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="guardarNuevoRol()"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="modalPermisos" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Asignar Permisos</h4>
                <small id="nameRol" class="font-bold">Asignar Permisos al ROL</small>
                <input type="text" placeholder="Ingrese el nombre del rol" class="form-control" id='idRol' hidden>
            </div>
            <div class="modal-body">

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cod.</th>
                            <th>Permiso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permisos as $permiso)
                        <tr>
                            <td>
                                <input type="checkbox" class="i-checks flat chekboxses" name="idPermiso[]" value="{{ $permiso->id }}" id="idPermiso">
                            </td>
                            <td> {{ $permiso->id }} </td>
                            <td> {{ $permiso->name }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="asignarPermisoRol()"><i class="fa fa-save"></i> Asignar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

    <script>

        function asignarPermisoRol() {

            var rol_id = $('#idRol').val();
            var idPermiso=[];

            $('.chekboxses:checked').each(
                function() {
                    idPermiso.push($(this).val());
                }
            );

            $.post( "{{ Route('asignarPermisoRol') }}", {idPermiso: idPermiso, rol_id: rol_id, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#tabPermisos").empty();
                $("#tabPermisos").html(data.view);
                $('#modalPermisos').modal('hide');

                if (data.resp == 1) {

                    Swal.fire({
                        title: "Guardado",
                        text: "El permiso se asignó correctamente",
                        icon: "success"
                    });

                } else {

                    Swal.fire({
                        title: "Guardado",
                        text: "El permiso no se asignó correctamente",
                        icon: "error"
                    });

                }

            });
        }

        function nuevoRol() {
            $('#modalRol').modal('show');
        }

        function asignarPermiso() {
            $('#modalPermisos').modal('show');
        }

        function verPermisos(idRol) {
            $('#idRol').val(idRol);
            $('#btnAsignar').show();
            $.post("{{ Route('verPermisos') }}", {id: idRol, _token: '{{ csrf_token() }}'}).done(function(data) {
                $("#tabPermisos").empty();
                $("#tabPermisos").html(data.view);
            });
        }

        function guardarNuevoRol() {
            var name = $("#name").val();

            $.post("{{ Route('saveRol') }}", {name: name, _token: '{{ csrf_token() }}'}).done(function(data) {
                $('#modalRol').modal('hide');
                $("#tabRoles").empty();
                $("#tabRoles").html(data.view);
                if (data.resp == 1) {

                    Swal.fire({
                        title: "Guardado",
                        text: "El rol se guardó correctamente",
                        icon: "success"
                    });

                } else {

                    Swal.fire({
                        title: "Guardado",
                        text: "El rol no pudo ser guardado",
                        icon: "error"
                    });

                }

            });

        }

    </script>
@endsection
