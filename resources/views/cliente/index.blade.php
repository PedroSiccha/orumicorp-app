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
                    {{-- @can('Asignar Cliente Masivo') --}}
                        <button id="asignarBtn" type="button" class="btn btn-info" type="button" onclick="mostrarNuevoModal('#modalAsignAgent')" style="display: none;"><i class="fa fa-group"></i> Asignar Agente</button>
                    {{-- @endcan --}}
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
              <a href="#" class="dropdown-item" onclick="mostrarNuevoModal('#modalAsignar')">Asignar</a>
              <div class="ibox-content" >
                <div class="table-responsive" id="tabClient">
                    @include('cliente.list.listCustomer')
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

                {{-- <table class="table m-b-xs">
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
                </table> --}}
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
                <div class="row">
                    <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">Datos Personales</h3>
                        <div class="form-group">
                            <label>Código</label>
                            <input id="code" type="text" placeholder="Ingrese Código" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nombres</label>
                            <input id="name" type="text" placeholder="Ingrese Nombre" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input id="lastname" type="text" placeholder="Ingrese Apellido" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input id="phone" type="text" placeholder="Ingrese Teléfono" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Teléfono Opcional</label>
                            <input id="optionalPhone" type="text" placeholder="Ingrese Teléfono Opcional" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Correo</label>
                            <input id="email" type="email" placeholder="Ingrese Correo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Ciudad</label>
                            <input id="city" type="text" placeholder="Ingrese Ciudad" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>País</label>
                            <input id="country" type="text" placeholder="Ingrese País" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Proveedor</label>
                            <select name="provider" id="provide_id" class="form-control m-b">
                                <option>Seleccione un proveedor</option>
                                @foreach ($providers as $provider)
                                    <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Platform</label>
                            <select name="platform" id="platform_id" class="form-control m-b">
                                <option>Seleccione su platform</option>
                                @foreach ($platforms as $platform)
                                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Traiding</label>
                            <select name="traiding" id="traiding_id" class="form-control m-b">
                                <option>Seleccione su Traiding</option>
                                @foreach ($traidings as $traiding)
                                    <option value="{{ $traiding->id }}">{{ $traiding->name }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info" type="button" onclick="guardarNuevoCliente('#code', '#name', '#lastname', '#phone', '#optionalPhone', '#email', '#city', '#country', '#provide_id', '#traiding_id', '#platform_id', '#modalCliente', '#tabClient')"><i class="fa fa-save"></i> Guardar</button>
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
<script src="{{ asset('js/utils/viewCheck.js') }}"></script>

<script>
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

    function fetch_data(page) {
        $.ajax({
            url: "/clientsPagination?page=" + page,
            success: function(data) {
                $('#tabClient').html(data);
            }
        });
    }
</script>
@endsection
