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
                    @can('Asignar Cliente Masivo')
                        <button type="button" class="btn btn-info" type="button" onclick="mostrarNuevoModal('#modalAsignAgent')"><i class="fa fa-group"></i> Asignar Agente</button>
                    @endcan
                    @can('Crear Cliente')
                    <button type="button" class="btn btn-default" type="button" onclick="mostrarNuevoModal('#modalCliente')"><i class="fa fa-plus"></i> Nuevo Cliente</button>
                    @endcan
                    @can('Carga Masiva de Cliente')
                    <button type="button" class="btn btn-success" type="button" onclick="mostrarNuevoModal('#modalChargeGroup')"><i class="fa fa-upload"></i> Carga Masiva</button>
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
                            <tr @if($customer->status == 0) class="table-danger" @endif>
                                <td>{{  date("d/m/Y", strtotime($customer->date_admission)) }}</td>
                                <td>{{ $customer->code }}</td>
                                <td>
                                    <a href="{{ route('perfilUsuario', ['id' => $customer->id]) }}">
                                        {{ $customer->name }} {{ $customer->lastname }}</td>
                                    </a>
                                <td>
                                    @can('Asignar Agente')
                                        <button class="btn btn-default " type="button" onclick="asignarAgente('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#modalAsignarAgente', '#aId', '#nameClient')"><i class="fa fa-user"></i></button>
                                    @endcan
                                    @can('Estado Cliente')
                                        @if ($customer->status == 0)
                                            <button class="btn btn-info " type="button" onclick="cambiarEstado('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient', '1')"><i class="fa fa-check"></i></button>
                                        @else
                                            <button class="btn btn-danger " type="button" onclick="cambiarEstado('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient', '0')"><i class="fa fa-minus"></i></button>
                                        @endif
                                    @endcan
                                    @can('Editar Cliente')
                                    <button class="btn btn-warning " type="button" onclick="editarCliente(
                                        '{{ $customer->id }}',
                                        '{{ $customer->code }}',
                                        '{{ $customer->name }}',
                                        '{{ $customer->lastname }}',
                                        '{{ $customer->dni }}',
                                        '{{ $customer->user->email }}',
                                        '#modalEditarCliente',
                                        '#eId',
                                        '#eCode',
                                        '#eName',
                                        '#eLastname',
                                        '#ePhone',
                                        '#eEmail'
                                        )"><i class="fa fa-pencil"></i></button>
                                    @endcan
                                    @can('Eliminar Cliente')
                                        <button class="btn btn-danger " type="button" onclick="eliminarCliente('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient')"><i class="fa fa-trash"></i></button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                  </table>
                <div class="pagination justify-content-center">
                    {{ $customers->links() }}
                </div>
              </div>
          </div>
      </div>
  </div>


  <div class="modal inmodal fade" id="modalChargeGroup" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Cargar Clientes de Manera Masiva</h4>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Formato</label>
                    <div class="input-group col-lg-9">
                        <button type="button" class="btn btn-primary"><i class="fa fa-download"></i></button>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Subir Archivo</label>
                    <div class="col-lg-9">
                        <input type="file" placeholder="Nombre del agente" class="form-control" readonly>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="ladda-button ladda-button-demo btn btn-info" data-style="zoom-in" type="button" onclick="assignGroupAgent('#idGroupClientes', '#dniGroupAgent', '#modalAsignAgent', '#tabClient')"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>


  <div class="modal inmodal fade" id="modalAsignAgent" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Asignar Clientes</h4>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniGroupAgent" placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" onclick="searchAgent('#dniGroupAgent', '#nameGroupAgent')"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id='nameGroupAgent' readonly>
                    </div>
                </div>

                <table class="table m-b-xs">
                    <tbody>
                        <tr>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cod.</th>
                                        <th>Clientes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asignCustomers as $asignCustomer)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="i-checks flat chekboxses" name="idGroupClientes[]" value="{{ $asignCustomer->id }}" id="idGroupClientes">
                                        </td>
                                        <td> {{ $asignCustomer->code }} </td>
                                        <td> {{ $asignCustomer->name }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button class="ladda-button ladda-button-demo btn btn-info" data-style="zoom-in" type="button" onclick="assignGroupAgent('#idGroupClientes', '#dniGroupAgent', '#modalAsignAgent', '#tabClient')"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
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
                                <strong>Teléfono</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su teléfono" id='dni'>
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
                <button class="ladda-button ladda-button-demo btn btn-info" data-style="zoom-in" type="button" onclick="guardarNuevoCliente('#name', '#lastname', '#dni', '#email', '#code', '#rol_id', '#modalCliente', '#tabClient')"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="modalEditarCliente" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Cliente</h4>
                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Id Cliente" id='eId' hidden>
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
                                <strong>Teléfono</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su teléfono" id='ePhone'>
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
                <button class="btn btn-info " type="button" onclick="updateClient(
                    '#modalEditarCliente',
                    '#eId',
                    '#eCode',
                    '#eName',
                    '#eLastname',
                    '#ePhone',
                    '#eEmail',
                    '#eRol_id',
                    '#tabClient')"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="modalAsignarAgente" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Asignar Agente</h4>
                <input type="text" placeholder="Nombre del cliente" class="form-control" id='aId' readonly hidden>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Cliente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id='nameClient' readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniAgent" placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" onclick="searchAgent('#dniAgent', '#nameAgent')"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id='nameAgent' readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="guardarAsignacionAgente('#aId', '#dniAgent', '#modalAsignarAgente', '#tabClient')"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var saveCustomerRoute = '{{ route("saveCustomer") }}';
    var searchAgentRoute = '{{ route("searchAgent") }}';
    var updateClientRoute = '{{ route("updateClient") }}';
    var deleteClientRoute = '{{ Route("deleteClient") }}';
    var changeStatusClienteRoute = '{{ Route("changeStatusClient") }}';
    var asignAgentRoute = '{{ route("asignAgent") }}';
    var assignGroupAgentRoute = '{{ route("assignGroupAgent") }}';
    var token = '{{ csrf_token() }}';
</script>
<script src="{{asset('js/agent/assignAgent.js')}}"></script>
<script src="{{asset('js/agent/searchAgent.js')}}"></script>
<script src="{{ asset('js/customer/createClient.js') }}"></script>
<script src="{{ asset('js/customer/editClient.js') }}"></script>
<script src="{{ asset('js/customer/changeStatusClient.js') }}"></script>
<script src="{{ asset('js/customer/deleteClient.js') }}"></script>
<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/utils/getIp.js') }}"></script>
<script src="{{ asset('js/agent/assignGroupAgent.js') }}"></script>
@endsection
