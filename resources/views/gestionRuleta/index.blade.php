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
                    <button type="button" class="btn btn-default" type="button" onclick="mostrarNuevoModal('#modalPremio')"><i class="fa fa-plus"></i> Registrar Premio</button>
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
                        <input type="number" placeholder="Ingrese el valor del premio" class="form-control" id='valorPremio' style="@if($errors->has('valorPremio')) border-color: red; @endif" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Orden</label>
                    <div class="col-lg-9">
                        <select class="form-control m-b" name="orden" id="orden">
                            <option value = "1">Seleccionar un orden</option>
                            <option value = "1">Premio 01</option>
                            <option value = "2">Premio 02</option>
                            <option value = "3">Premio 03</option>
                            <option value = "4">Premio 04</option>
                            <option value = "5">Penalización 01</option>
                            <option value = "6">Penalización 02</option>
                            <option value = "7">Penalización 03</option>
                            <option value = "8">Penalización 04</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="createAward('#namePremio', '#description', '#valorPremio', '#orden', '#modalPremio', '#tabPremio')"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var savePremioRoute = '{{ route("savePremio") }}';
    var token = '{{ csrf_token() }}';
</script>

<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/rouletteManagement/createAward.js') }}"></script>

@endsection
