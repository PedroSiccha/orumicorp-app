@extends('layouts.app')
@section('title')
      Perfil de Usuario
@endsection

@section('content')

<div class="row m-b-lg m-t-lg">

    <div class="col-md-6">
        <div class="profile-image">
            <img src="asset/img/a4.jpg" class="rounded-circle circle-border m-b-md" alt="profile">
        </div>
        <div class="profile-info">
            <div class="">
                <div>
                    <h2 class="no-margins">
                        {{ $dataCustomer->name }} {{ $dataCustomer->lastname }}
                    </h2>
                    <h4>{{ $dataCustomer->email }}</h4>
                    <small>
                        {{ $dataCustomer->comment }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-4">

            <div class="ibox">
                <div class="ibox-content">
                        <h3>{{ $dataCustomer->name }} {{ $dataCustomer->lastname }}</h3>

                    <p class="small">
                        {{ $dataCustomer->commnet }}
                        <br/>
                        <br/>
                    </p>

                    <p class="small font-bold">
                        <span><i class="fa fa-circle text-navy"></i> {{ $dataCustomer->status }}</span>
                        </p>

                </div>
            </div>

            <div class="ibox">
                <div class="ibox-content">
                    <h3>Datos Personales</h3>

                    <div class="form-group">
                        <label>Código</label>
                        <input type="text" class="form-control" placeholder="Ingrese su código" id="code" value="{{ $dataCustomer->code }}">
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" placeholder="Ingrese su nómbre" id="name" value="{{ $dataCustomer->name }}">
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" class="form-control" placeholder="Ingrese su apellido" id="lastname" value="{{ $dataCustomer->lastname }}">
                    </div>
                    <div class="form-group">
                        <label>Corréo</label>
                        <input type="email" class="form-control" placeholder="Ingrese su corréo" id="email" value="{{ $dataCustomer->email }}">
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" placeholder="Ingrese su teléfono" id="phone" value="{{ $dataCustomer->phone }}">
                    </div>
                    <div class="form-group">
                        <label>Teléfono Opcional</label>
                        <input type="text" class="form-control" placeholder="Ingrese su teléfono opcional" id="optionalPhone" value="{{ $dataCustomer->optional_phone }}">
                    </div>
                    <div class="form-group">
                        <label>Ciudad</label>
                        <input type="text" class="form-control" placeholder="Ingrese su ciudad" id="city" value="{{ $dataCustomer->city }}">
                    </div>
                    <div class="form-group">
                        <label>País</label>
                        <input type="text" class="form-control" placeholder="Ingrese su país" id="country" value="{{ $dataCustomer->country }}">
                    </div>
                    <div class="form-group">
                        <label>Comentario</label>
                        <textarea class="form-control" placeholder="Ingrese su comentario" rows="3" id="comment">{{ $dataCustomer->comment }}</textarea>
                    </div>
                    <button class="btn btn-primary btn-block">Actualizar</button>
                </div>
            </div>

            <div class="ibox">
                <div class="ibox-content">
                    <h3>Mensajes</h3>

                    <p class="small">
                        Enviar mensaje
                    </p>

                    <div class="form-group">
                        <label>Asunto</label>
                        <input type="text" class="form-control" placeholder="Ingrese su asunto" id="subject">
                    </div>
                    <div class="form-group">
                        <label>Mensaje</label>
                        <textarea class="form-control" placeholder="Ingrese su mensaje" rows="3" id="message"></textarea>
                    </div>
                    <button class="btn btn-primary btn-block">Enviar</button>
                </div>
            </div>

        </div>

        <div class="col-lg-8">

            <div class="social-feed-box">

                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-3"> <i class="fa fa-newspaper-o"></i> Resumen</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-4"><i class="fa fa-comment-o"></i> Comentarios</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-5"><i class="fa fa-mobile"></i> Llamadas</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-6"><i class="fa fa-calendar"></i> Task</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-5"><i class="fa fa-comments-o"></i> Chat</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-3" class="tab-pane active">
                            <div class="panel-body">
                                <strong></strong>

                                <p></p>

                                <p></p>
                            </div>
                        </div>
                        <div id="tab-4" class="tab-pane">
                            <div class="panel-body">

                                <div class="ibox-content">

                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Comentario</th>
                                            <th>Agente</th>
                                            <th>Fecha Registro</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $dataCustomer->comment }}</td>
                                            <td>{{ $dataCustomer->agent_id }}</td>
                                            <td>{{ $dataCustomer->date_admission }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab-5" class="tab-pane">
                            <div class="panel-body">
                                <div class="ibox-content">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha de Llammada</th>
                                            <th>Agente</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>13/05/2024</td>
                                            <td>Agente de Prueba</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab-6" class="tab-pane">
                            <div class="panel-body">
                                <div class="ibox-content">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Hora Inicio</th>
                                            <th>Hora de Fin</th>
                                            <th>Evento</th>
                                            <th>Agente</th>
                                            <th>Prioridad</th>
                                            <th>Detalle</th>
                                            <th>Estado</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>13/05/2024</td>
                                            <td>13:30</td>
                                            <td>14:30</td>
                                            <td>Evento de Prueba</td>
                                            <td>Agente Prueba</td>
                                            <td>BAJO</td>
                                            <td>Esto es una prueba</td>
                                            <td>Pendiente</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
@section('script')
@endsection
