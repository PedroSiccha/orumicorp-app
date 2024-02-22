@extends('layouts.app')

@section('title')
      Gestión de Ruleta
@endsection

@section('content')
<div class="row">
      <div class="col-lg-12">
          <div class="ibox ">
              <div class="ibox-title d-flex justify-content-between align-items-center">
                  <h5>Datos de Premios </h5>
                  <div>
                    @can('Registrar Premio Ruleta')
                    <button type="button" class="btn btn-default" type="button" onclick="nuevoPremio()"><i class="fa fa-plus"></i> Registrar Premio</button>
                    @endcan
                  </div>
              </div>
              <div class="ibox-content" id="tabPremio">
                  <table class="table table-striped">
                      <thead>
                      <tr>
                          <th>Fecha de Ingreso</th>
                          <th>Premio</th>
                          <th>Descripción</th>
                          <th>Valor</th>
                          <th>Estado</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($premios as $premio)
                        <tr>
                            <td>{{ $premio->created_at }}</td>
                            <td>{{ $premio->name }}</td>
                            <td>{{ $premio->description }}</td>
                            <td>{{ $premio->value }}</td>
                            <td>{{ $premio->status }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>

<div class="modal inmodal fade" id="modalPremio" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nuevo Premio</h4>
                <small class="font-bold">Registre su premio</small>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nombre del Premio</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Ingrese el nombre del premio" class="form-control" id='namePremio'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Descripción</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Ingrese una descripción" class="form-control" id='description'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Valor del Premio</label>
                    <div class="col-lg-9">
                        <input type="number" placeholder="Ingrese el valor del premio" class="form-control" id='valorPremio'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="guardarPremio()"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

    <script>

        function nuevoPremio() {
            $('#modalPremio').modal('show');
        }

        function guardarPremio() {
            var nombre = $("#namePremio").val();
            var descripcion = $("#description").val();
            var valor = $("#valorPremio").val();
            $.post("{{ Route('savePremio') }}", {nombre: nombre, descripcion: descripcion, valor: valor, _token: '{{ csrf_token() }}'}).done(function(data) {
                $('#modalPremio').modal('hide');
                $("#tabPremio").empty();
                $("#tabPremio").html(data.view);
                if (data.resp == 1) {

                    Swal.fire({
                        title: "Correcto",
                        text: "El premio se registró correctamente",
                        icon: "success"
                    });

                } else {

                    Swal.fire({
                        title: "Error",
                        text: "El premio no se pudo registrar",
                        icon: "error"
                    });

                }

            });
        }

    </script>

@endsection
