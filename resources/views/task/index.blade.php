@extends('layouts.app')

@section('title')
      Task
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div id="task"></div>

    <button class="btn btn-info " type="button" data-toggle="modal" data-target="#modalRegistrarEvento"><i class="fa fa-calendar"></i> Crear Evento</button>

    <div class="modal inmodal fade" id="modalRegistrarEvento" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Registrar Evento</h4>
                    <input type="text" placeholder="Nombre del cliente" class="form-control" id='aId' readonly hidden>
                </div>
                <div class="modal-body">
                    <div class="form-group row" hidden>
                        <label class="col-lg-3 col-form-label">ID</label>
                        <div class="col-lg-9">
                            <input type="text" placeholder="Nombre del evento" class="form-control" id='id' name='id'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Fecha</label>
                        <div class="col-lg-9">
                            <input type="date" placeholder="Nombre del evento" class="form-control" id='dateEvent' name='dateEvent' readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Nombre del Evento</label>
                        <div class="col-lg-9">
                            <input type="text" placeholder="Nombre del evento" class="form-control" id='nombreEvento'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Descripción</label>
                        <div class="input-group col-lg-9">
                            <textarea type="text" placeholder="Descripción del evento" class="form-control" id='descripcionEvento'></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Código del Cliente</label>
                        <div class="col-lg-9">
                            <div class="input-group">
                                <input type="text" class="form-control" id="dniCustomer" placeholder="Ingrese el DNI o Código del cliente">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" onclick="searchClient('#dniCustomer', '#nameCustomer')"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Nombre del Cliente</label>
                        <div class="col-lg-9">
                            <input type="text" placeholder="Nombre del Cliente" class="form-control" id='nameCustomer' readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Desde</label>
                        <div class="col-lg-9">
                            <input type="time" placeholder="Desde" class="form-control" id='horaInicio'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Hasta</label>
                        <div class="col-lg-9">
                            <input type="time" placeholder="Nombre del agenteHasta" class="form-control" id='horaFin'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Prioridad</label>
                        <div class="col-lg-9">
                            <select class="form-control m-b" name="priority_id" id="priority_id">
                                <option>Nivel de Prioridad</option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}" class="{{ $priority->color }}">{{ $priority->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success " type="button" onclick="saveEvent('#id', '#dateEvent', '#nombreEvento', '#descripcionEvento', '#dniCustomer', '#horaInicio', '#horaFin', '#priority_id', '#modalRegistrarEvento', '#tabClient')"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn btn-warning " type="button" onclick="editEvent('#aId', '#dniAgent', '#modalAsignarAgente', '#tabClient')"><i class="fa fa-pencil"></i> Modificar</button>
                    <button class="btn btn-danger " type="button" onclick="deleteEvent('#aId', '#dniAgent', '#modalAsignarAgente', '#tabClient')"><i class="fa fa-trash"></i> Eliminar</button>
                    <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/calendar/script.js') }}"></script>
<script src="{{ asset('js/customer/searchClient.js') }}"></script>
<script src="{{ asset('js/customer/uploadExcel.js') }}"></script>
<script src="{{ asset('js/task/saveEvent.js') }}"></script>
<script src="{{ asset('js/task/editEvent.js') }}"></script>
<script src="{{ asset('js/task/deleteEvent.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script>
    var searchClientRoute = '{{ route("searchCustomer") }}';
    var uploadExcelRoute = '{{ route("uploadExcel") }}';
    var saveEventRoute = '{{ route("saveEvent") }}';
    var token = '{{ csrf_token() }}';
  </script>
@endsection
