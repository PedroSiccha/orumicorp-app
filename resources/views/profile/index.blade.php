
@extends('layouts.app')

@section('title')
      Perfil de Usuario
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row m-b-lg m-t-lg">
        <div class="col-md-6">

            <div class="profile-image">
                <img src="{{  asset($dataUser->img) ?: asset('img/logo/basic_logo.png') }}" class="rounded-circle circle-border m-b-md" alt="profile">
            </div>
            <div class="profile-info">
                <div class="">
                    <div>
                        <h2 class="no-margins">
                            {{ $dataUser->name }} {{ $dataUser->lastname }}
                        </h2>
                        <h4>{{ Auth::user()->email }}</h4>
                        <small>
                            {{ Auth::user()->getRoleNames()->first() }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <table class="table small m-b-xs">
                <tbody>
                <tr>
                    <td>
                        Ingreso
                    </td>
                    <td>
                        @if ($dateIn)
                            <strong>{{ $dateIn->hour ?: 0 }}</strong>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        Break
                    </td>
                    <td>
                        @if ($dateBreakIn)
                            <strong>{{ $dateBreakIn->hour }}</strong>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        Vuelta Break
                    </td>
                    <td>
                        @if ($dateBreakOut)
                            <strong>{{ $dateBreakOut->hour }}</strong>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        Salida
                    </td>
                    <td>
                        @if ($dateOut)
                            <strong>{{ $dateOut->hour }}</strong>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3" id="divTarg">
            <small>Target del Mes</small>
            <h2 class="no-margins">206 480</h2>
        </div>


    </div>
    <div class="row">

        <div class="col-lg-5">

            <div class="ibox">
                <div class="ibox-content">
                    <h3>Opciones</h3>
                    <div class="btn-group">
                        <label title="Upload image file" for="inputImage" class="btn btn-primary">
                            <input type="file" accept="image/*" name="file" id="inputImage" class="hide">
                            Subir Imagen
                        </label>
                        <label title="Donload image" id="download" class="btn btn-primary" onclick="uploadImg('inputImage')">Subir</label>
                    </div>
                    {{-- @can('Cambiar Contraseña') --}}
                        <button class="btn btn-warning btn-block" onclick="mostrarNuevoModal('#modalChangePassword')">Cambiar Contraseña</button>
                    {{-- @endcan --}}
                </div>
            </div>

        </div>

        <div class="col-lg-3">

            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Lista de Clientes Asignados</h5>
                </div>
                <div class="ibox-content table-responsive">
                    <table class="table table-hover no-margins">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>Cliente</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $client->code }}</td>
                                    <td>{{ $client->name }} {{ $client->lastname }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-lg-4 m-b-lg">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Historial de Target</h5>
                </div>
                <div class="ibox-content table-responsive" id="tabTarget">
                    <table class="table table-hover no-margins">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>Mes</th>
                            <th>Monto</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($targets as $target)
                                <tr>
                                    <td>{{ $target->id }}</td>
                                    <td>{{ $target->mes }}</td>
                                    <td>$ {{ number_format($target->amount, 2) }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-8 m-b-lg">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Historial de Ventas</h5>
                </div>
                <div class="ibox-content table-responsive">
                    <table class="table table-hover no-margins">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>Fecha de Ingreso</th>
                            <th>Monto</th>
                            <th>Comisión</th>
                            <th>Cliente</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->id }}</td>
                                    <td> {{ $sale->date_admission }} </td>
                                    <td>{{ $sale->amount }}</td>
                                    <td> {{ $sale->commission }} </td>
                                    <td>{{ $sale->name }} {{ $sale->lastname }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Totales</h5>
                        <div class="ibox-tools">
                            {{-- @can('Registrar Target') --}}
                            <a onclick="mostrarNuevoModal('#modalCreateTarget')">
                                <i class="fa fa-plus"></i>
                            </a>
                            {{-- @endcan --}}
                        </div>
                    </div>
                    {{-- @can('Perfil - Ver Target Mensual') --}}
                        <div class="ibox-content navy-bg">
                            <div class="row" id="tabTotalTarget">
                                <div class="col-4">
                                    <h4>Target Mensual</h4>
                                </div>

                                <div class="col-4">
                                    <h4>${{ isset($targetMensual->amount) ? number_format($targetMensual->amount, 2) : '0.00' }}</h4>
                                </div>
                                <div class="col-4">
                                    <h4>S/. {{ isset($targetMensual->amount) ? number_format(($targetMensual->amount)*3.5, 2) : '0.00' }}</h4>
                                </div>
                            </div>
                        </div>
                    {{-- @endcan
                    @can('Perfil - Ver Ingresos Actuales') --}}
                        <div class="ibox-content yellow-bg">
                            <div class="row">
                                <div class="col-4">
                                    <h4>Ingresos Actuales</h4>
                                </div>

                                <div class="col-4">
                                    <h4>$ {{ number_format($ingresosActuales ?: 0, 2) }}</h4>
                                </div>
                                <div class="col-4">
                                    <h4>S/. {{ number_format(($ingresosActuales ?: 0)*3.5, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    {{-- @endcan
                    @can('Perfil - Ver Retiros Actuales') --}}
                        <div class="ibox-content red-bg">
                            <div class="row">
                                <div class="col-4">
                                    <h4>Retiros Actuales</h4>
                                </div>

                                <div class="col-4">
                                    <h4>$ {{ number_format($amountRetiro ?: 0, 2) }}</h4>
                                </div>
                                <div class="col-4">
                                    <h4>S/. {{ number_format(($amountRetiro ?: 0)*3.5, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    {{-- @endcan
                    @can('Perfil - Ver Cuota Pendiente') --}}
                        <div class="ibox-content lazur-bg">
                            <div class="row">
                                <div class="col-4">
                                    <h4>Cuota Pendiente</h4>
                                </div>

                                <div class="col-4">
                                    <h4>$ {{  isset($targetMensual->amount) ? number_format($targetMensual->amount - $ingresosActuales, 2) : '0.00' }}</h4>
                                </div>
                                <div class="col-4">
                                    <h4>S/. {{ isset($targetMensual->amount) ? number_format(($targetMensual->amount - $ingresosActuales)*3.5, 2): '0.00' }}</h4>
                                </div>
                            </div>
                        </div>
                    {{-- @endcan
                    @can('Perfil - Ver Pago en Efectivo') --}}
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-4">
                                    <h4>Pago en Efectivo</h4>
                                </div>

                                <div class="col-4">
                                    <h4>$ 0.00</h4>
                                </div>
                                <div class="col-4">
                                    <h4>S/. 0.00</h4>
                                </div>
                            </div>
                        </div>
                    {{-- @endcan
                    @can('Perfil - Ver Descuentos') --}}
                        <div class="ibox-content red-bg">
                            <div class="row">
                                <div class="col-4">
                                    <h4>Descuentos</h4>
                                </div>

                                <div class="col-4">
                                    <h4>$ 0.00</h4>
                                </div>
                                <div class="col-4">
                                    <h4>S/. 0.00</h4>
                                </div>
                            </div>
                        </div>
                    {{-- @endcan --}}
                </div>
            </div>
    </div>
</div>

<div class="modal inmodal fade" id="modalChangePassword" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Asignar Nueva Contraseña</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Contraseña</label>
                    <div class="col-lg-9">
                        <input type="password" placeholder="Ingrese su nueva contraseña" class="form-control" id='newPassword'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="changePassword('#newPassword', '#modalChangePassword')"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="modalCreateTarget" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Asignar Target</h4>
                @if ($targetMensual)
                    <small>{{ number_format($targetMensual->amount, 2) }}</small>
                @endif
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Target</label>
                    <div class="col-lg-9">
                        <input id="amountTarget" type="text" placeholder="Ingrese el target para el agente" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                @if ($targetMensual)
                    <button class="btn btn-success " type="button" onclick="updateTarget('#amountTarget', '#modalCreateTarget', '#divTarget', '#tabTarget', '#tabTotalTarget')"><i class="fa fa-refresh"></i> Actualizar</button>
                    <button class="btn btn-info " type="button" onclick="addTarget('#amountTarget', '#modalCreateTarget', '#divTarget', '#tabTarget', '#tabTotalTarget')"><i class="fa fa-plus"></i> Agregar</button>
                @else
                    <button class="btn btn-success " type="button" onclick="createTarget('#amountTarget', '#modalCreateTarget', '#divTarget', '#tabTarget', '#tabTotalTarget')"><i class="fa fa-save"></i> Guardar</button>
                @endif

                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/agent/uploadImg.js') }}"></script>
<script src="{{ asset('js/agent/changePassword.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>

<script src="{{ asset('js/target/createTarget.js') }}"></script>
<script src="{{ asset('js/target/updateTarget.js') }}"></script>
<script src="{{ asset('js/target/addTarget.js') }}"></script>
<script>
    var uploadImgRoute = '{{ route("uploadImg") }}';
    var changePasswordRoute = '{{ route("changePassword") }}';
    var saveTargetRoute = '{{ route("saveTarget") }}';
    var updateTargetRoute = '{{ route("updateTarget") }}';
    var addTargetRoute = '{{ route("addTarget") }}';
    var token = '{{ csrf_token() }}';
</script>
@endsection
