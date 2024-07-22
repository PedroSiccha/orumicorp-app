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
                  <div class="ibox-tools">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="#" class="dropdown-item" onclick="mostrarNuevoModal('#modalConfigTableLocal')">Configurar Tabla</a>
                            <!-- <a href="#" class="dropdown-item" onclick="mostrarNuevoModal('#modalConfigTable')">Configurar Tabla</a> -->
                        </li>
                    </ul>
                </div>
              </div>
              <div class="ibox-content" id="tabClient">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Ultima llamada</th>
                                <th>ID de Cliente</th>
                                <th>Fecha de Ingreso</th>
                                <th>Fecha de Última Llamada</th>
                                <th>Fecha de Última Asignación</th>
                                <th>Asignado Por</th>
                                <th>Proveedor</th>
                                <th>Campaña</th>
                                <th>Nombre del Cliente</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Teléfono Opcional</th>
                                <th>Ciudad</th>
                                <th>Pais</th>
                                <th>Estado</th>
                                <th>Agente</th>
                                <th>Comentario</th>
                                <th>Última Visita</th>
                                <th>FTD Date</th>
                                <th>Método</th>
                                <th>N° de Depósito</th>
                                <th>Total Depósitos</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr class="{{ $customer->status_color }}">
                                    <td>{{ $customer->last_communication_date }}</td>
                                    <td>{{ $customer->customer_id }}</td>
                                    <td>{{  date("d/m/Y", strtotime($customer->date_admission)) }}</td>
                                    <td>{{ $customer->last_communication_date }}</td>
                                    <td>{{ $customer->last_assignment_date }}</td>
                                    <td>{{ $customer->assignment_description }}</td>
                                    <td>{{ $customer->provider_name }}</td>
                                    <td>{{ $customer->campaign_name }}</td>
                                    <td>
                                        <a href="{{ route('profileClient', ['id' => $customer->customer_id]) }}">
                                            {{ $customer->customer_name }}
                                        </a>
                                    </td>
                                    <td>{{ $customer->user_email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->phone }}</td> <!-- Modificar Número Opcional -->
                                    <td>{{ $customer->city }}</td>
                                    <td>{{ $customer->country }}</td>
                                    <td>{{ $customer->customer_status }}</td> <!-- Modificar Tiene que ser de la tabla ESTADOS -->
                                    <td>{{ $customer->agent_name }}</td>
                                    <td>{{ $customer->communication_comment }}</td>
                                    <td>{{ $customer->last_communication_date }}</td>
                                    <td>{{ $customer->last_communication_date }}</td>
                                    <td>{{ $customer->deposit_type }}</td>
                                    <td>{{ $customer->deposit_number }}</td>
                                    <td>{{ $customer->total_deposit }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-success" type="button" onclick="initiateCall({phone: '{{ $customer->phone }}', modal: '#modalCrearComentario', input: '#idComunication'})"><i class="fa fa-phone"></i> </button>
                                            @can('Asignar Agente')
                                                <button class="btn btn-default " type="button" onclick="asignarAgente('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#modalAsignarAgente', '#aId', '#nameClient')"><i class="fa fa-user"></i></button>
                                            @endcan
                                            {{-- @can('Estado Cliente')
                                                @if ($customer->status == 0)
                                                    <button class="btn btn-info " type="button" onclick="cambiarEstado('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient', '1')"><i class="fa fa-check"></i></button>
                                                @else
                                                    <button class="btn btn-danger " type="button" onclick="cambiarEstado('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient', '0')"><i class="fa fa-minus"></i></button>
                                                @endif
                                            @endcan --}}
                                            @can('Editar Cliente')
                                            <button class="btn btn-warning " type="button" onclick="editarCliente(
                                                '{{ $customer->customer_id }}',
                                                '{{ $customer->code }}',
                                                '{{ $customer->name }}',
                                                '{{ $customer->lastname }}',
                                                '{{ $customer->phone }}',
                                                '{{ $customer->optional_phone }}',
                                                '{{ $customer->city }}',
                                                '{{ $customer->country }}',
                                                '{{ $customer->comment }}',
                                                '{{ $customer->email }}',
                                                '#modalEditarCliente',
                                                '#eId',
                                                '#eCode',
                                                '#eName',
                                                '#eLastname',
                                                '#ePhone',
                                                '#eOptionalPhone',
                                                '#eCity',
                                                '#eCountry',
                                                '#eComment',
                                                '#eEmail'
                                                )"><i class="fa fa-pencil"></i></button>
                                            @endcan
                                            @can('Eliminar Cliente')
                                                <button class="btn btn-danger " type="button" onclick="eliminarCliente('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient')"><i class="fa fa-trash"></i></button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                        <a href="{{ route('descargarArchivo') }}" class="btn btn-primary"><i class="fa fa-download"></i> Descargar archivo</a>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Subir Archivo</label>
                    <div class="col-lg-9">
                        <input type="file" placeholder="Nombre del agente" id="fileExcel" class="form-control">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="ladda-button ladda-button-demo btn btn-info" data-style="zoom-in" type="button" onclick="uploadExcel('fileExcel')"><i class="fa fa-save"></i> Guardar</button>
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
                                <input style='font-size: large;' type='phone' class='form-control text-success' placeholder="Ingrese su teléfono" id='phone'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Teléfono Opcional</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='phone' class='form-control text-success' placeholder="Ingrese un teléfono opcional" id='optionalPhone'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Correo</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='email' class='form-control text-success' placeholder="Ingrese su Correo" id='email'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ciudad</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su Ciudad" id='city'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Pais</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su Pais" id='country'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Comentario</strong>
                            </td>
                            <td>
                                <textarea style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese un comentario" id='comment'></textarea>
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
                <button class="btn btn-info" type="button" onclick="guardarNuevoCliente('#code', '#name', '#lastname', '#phone', '#optionalPhone', '#email', '#city', '#country', '#comment',  '#rol_id', '#modalCliente', '#tabClient')"><i class="fa fa-save"></i> Guardar</button>
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
                                <strong>Teléfono Opcional</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese un teléfono opcional" id='eOptionalPhone'>
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
                                <strong>Ciudad</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su Ciudad" id='eCity'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Pais</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese su país" id='eCountry'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Comentario</strong>
                            </td>
                            <td>
                                <textarea style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese un comentario" id='eComment'></textarea>
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
                    '#eId',
                    '#eCode',
                    '#eName',
                    '#eLastname',
                    '#ePhone',
                    '#eOptionalPhone',
                    '#eEmail',
                    '#eCity',
                    '#eCountry',
                    '#eComment',
                    '#eRol_id',
                    '#modalEditarCliente',
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

<div class="modal fade" id="callModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Llamadas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <iframe src="https://cc-dal01.voiso.com/stats" style="width:100%; height:500px;"></iframe>
        </div>
      </div>
    </div>
  </div>

    <div class="modal inmodal fade" id="modalConfigTable" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Configurar la tabla</h4>
                    <small id="nameRol" class="font-bold">Seleccione las columnas que quiere visualizar</small>
                    <input type="text" placeholder="Ingrese el nombre del rol" class="form-control" id='idRol' value="{{ $myRolesId }}" hidden>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-hover">

                        <tbody>
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks flat chekboxses" name="configTablesDateInit" id="configTablesDateInit" {{ $configTablesDateInit->status == 'active' ? 'checked' : '' }}>
                                </td>
                                <td> {{ $configTablesDateInit->name }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks flat chekboxses" name="configTablesCode" value="" id="configTablesCode" {{ $configTablesCode->status == 'active' ? 'checked' : '' }}>
                                </td>
                                <td> {{ $configTablesCode->name }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks flat chekboxses" name="configTablesPhone" value="" id="configTablesPhone" {{ $configTablesPhone->status == 'active' ? 'checked' : '' }}>
                                </td>
                                <td> {{ $configTablesPhone->name }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks flat chekboxses" name="configTablesOptionalPhone" value="" id="configTablesOptionalPhone" {{ $configTablesOptionalPhone->status == 'active' ? 'checked' : '' }}>
                                </td>
                                <td> {{ $configTablesOptionalPhone->name }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks flat chekboxses" name="configTablesEmail" value="" id="configTablesEmail" {{ $configTablesEmail->status == 'active' ? 'checked' : '' }}>
                                </td>
                                <td> {{ $configTablesEmail->name }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks flat chekboxses" name="configTablesCity" value="" id="configTablesCity" {{ $configTablesCity->status == 'active' ? 'checked' : '' }}>
                                </td>
                                <td> {{ $configTablesCity->name }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks flat chekboxses" name="configTablesCountry" value="" id="configTablesCountry" {{ $configTablesCountry->status == 'active' ? 'checked' : '' }}>
                                </td>
                                <td> {{ $configTablesCountry->name }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks flat chekboxses" name="configTablesComment" value="" id="configTablesComment" {{ $configTablesComment->status == 'active' ? 'checked' : '' }}>
                                </td>
                                <td> {{ $configTablesComment->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-info " type="button" onclick="saveConfigTable('#configTablesDateInit', '#configTablesCode', '#configTablesPhone', '#configTablesOptionalPhone', '#configTablesEmail', '#configTablesCity', '#configTablesCountry', '#configTablesComment', '#modalConfigTable', '#tabClient')"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para configurar la tabla -->
    <div class="modal fade" id="modalConfigTableLocal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Configurar la Tabla</h4>
                    <small class="font-bold">Seleccione las columnas que desea mostrar</small>
                </div>
                <div class="modal-body">
                    <form id="configTableForm">
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="0" checked> Ultima llamada</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="1" checked> ID de Cliente</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="2" checked> Fecha de Ingreso</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="3" checked> Fecha de Ultima Llamada</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="4" checked> Fecha de Última Asignación</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="5" checked> Asignado Por</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="6" checked> Proveedor</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="7" checked> Campaña</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="8" checked> Nombre del Cliente</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="9" checked> Correo</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="10" checked> Teléfono</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="11" checked> Teléfono Opcional</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="12" checked> Ciudad</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="13" checked> País</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="14" checked> Estado</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="15" checked> Agente</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="16" checked> Comentario</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="17" checked> Última Visita</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="18" checked> FTD Date</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="19" checked> Método</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="20" checked> N° de Depósito</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" class="column-toggle" data-column="21" checked> Total de Depósito</label>
                            </div>
                            <!-- Añadir más checkboxes para cada columna -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal" onclick="saveTableConfigLocal()">Guardar</button>
                    <button class="btn btn-default" type="button" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
</div>

   <!-- Modal para crear comentario -->
    <div class="modal inmodal fade" id="modalCrearComentario" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Registre su comentario</h4>
                    <input type="text" placeholder="idComunication" class="form-control" id='idComunication' readonly hidden>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Comentario</label>
                        <div class="col-lg-9">
                            <textarea style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese un comentario" id='txtComentario'></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info " type="button" onclick="guardarComentario({inputComunication: '#idComunication', modal: '#modalCrearComentario', inputComentario: '#txtComentario', table: '#tabClient'})"><i class="fa fa-save"></i> Guardar</button>
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
    var initiateCallRoute = '{{ route("initiateCall") }}';
    var uploadExcelRoute = '{{ route("uploadExcel") }}';
    var saveConfigTableRoute = '{{ route("saveConfigTable") }}';
    var saveComentarioRoute = '{{ route("saveComentario") }}';
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
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/voiso/initiateCall.js') }}"></script>
<script src="{{ asset('js/customer/uploadExcel.js') }}"></script>
<script src="{{ asset('js/customer/saveConfigTable.js') }}"></script>
<script src="{{ asset('js/customer/saveConfigTableLocal.js') }}"></script>
<script src="{{ asset('js/comentario/guardarComentario.js') }}"></script>
@endsection
