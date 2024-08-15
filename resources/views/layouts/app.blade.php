<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orumicorp - @yield('title')</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('js/calendar/style.css') }}">
    {{-- <link href="{{asset('ruleta/styles.css')}}" rel="stylesheet"> --}}
    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="{{ route('home') }}">
                                <img alt="image" class="rounded" src="{{asset('img/logo/logo_horizontal_ab.png')}}"
                                    width="90%" height="90%" />
                            </a>
                        </div>
                        <div class="logo-element">
                            <img alt="image" class="rounded-circle" src="{{asset('img/logo/basic_logo.png')}}"
                                width="50%" height="50%" />
                        </div>
                    </li>

                    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> <span
                                class="nav-label">Tablero</span> </a>
                    </li>

                    @can('Ver Agentes')
                    <li class="{{ Request::is('agents') ? 'active' : '' }}">
                        <a href="{{ route('agents') }}"><i class="fa fa-user-o"></i> <span
                                class="nav-label">Agentes</span></a>
                    </li>
                    @endcan
                    @can('Ver Area')
                    <li class="{{ Request::is('areas') ? 'active' : '' }}">
                        <a href="{{ route('areas') }}"><i class="fa fa-user-o"></i> <span
                                class="nav-label">Áreas</span></a>
                    </li>
                    @endcan
                    @can('Ver Cliente')
                    <li class="{{ Request::is('clients') ? 'active' : '' }}">
                        <a href="{{ route('clients') }}"><i class="fa fa-user-o"></i> <span
                                class="nav-label">Clientes</span></a>
                    </li>
                    @endcan
                    @can('Ver Ventas')
                    <li class="{{ Request::is('sales') ? 'active' : '' }}">
                        <a href="{{ route('sales') }}"><i class="fa fa-file-text-o"></i> <span
                                class="nav-label">Ventas</span></a>
                    </li>
                    @endcan
                    @can('Ver Bonus')
                    <li class="{{ Request::is('agentbonus') ? 'active' : '' }}">
                        <a href="{{ route('agentBonus') }}"><i class="fa fa-dot-circle-o"></i> <span
                                class="nav-label">Bonus agente </span></a>
                    </li>
                    @endcan
                    @can('Ver Today')
                    <li class="{{ Request::is('statisticstoday') ? 'active' : '' }}">
                        <a href="{{ route('statisticsToday') }}"><i class="fa fa-bar-chart"></i> <span
                                class="nav-label">Today Statistic</span></a>
                    </li>
                    @endcan
                    @can('Ver Gestión Ruleta')
                    <li class="{{ Request::is('gestionRuleta') ? 'active' : '' }}">
                        <a href="{{ route('gestionRuleta') }}"><i class="fa fa-bar-chart"></i> <span
                                class="nav-label">Gestión de Ruleta</span></a>
                    </li>
                    @endcan
                    @can('Ver Part Time')
                    <li class="{{ Request::is('parttime') ? 'active' : '' }}">
                        <a href="{{ route('partTime') }}"><i class="fa fa-clock-o"></i> <span class="nav-label">Part
                                Time</span></a>
                    </li>
                    @endcan
                    @can('Ver Seguridad')
                    <li class="{{ Request::is('security') ? 'active' : '' }}">
                        <a href="{{ route('security') }}"><i class="fa fa-lock"></i> <span
                                class="nav-label">Seguridad</span></a>
                    </li>
                    @endcan
                    @can('Ver Auditoria')
                    <li class="{{ Request::is('audit') ? 'active' : '' }}">
                        <a href="{{ route('audit') }}"><i class="fa fa-warning"></i> <span
                                class="nav-label">Auditoria</span></a>
                    </li>
                    @endcan
                    @can('Ver Task')
                    <li class="{{ Request::is('task') ? 'active' : '' }}">
                        <a href="{{ route('task') }}"><i class="fa fa-calendar"></i> <span
                                class="nav-label">Task</span></a>
                    </li>
                    @endcan
                    @can('Ver Task')
                    <li class="{{ Request::is('whatsapp') ? 'active' : '' }}">
                        <a href="{{ route('whatsapp') }}"><i class="fa fa-comments-o"></i> <span
                                class="nav-label">Whatsapp</span></a>
                    </li>
                    @endcan
                    @can('Ver Task')
                    <li class="{{ Request::is('shooter') ? 'active' : '' }}">
                        <a href="{{ route('shooter') }}"><i class="fa fa-superpowers"></i> <span
                                class="nav-label">Shooter</span></a>
                    </li>
                    @endcan
                    @can('Ver Task')
                    <li class="{{ Request::is('deposit') ? 'active' : '' }}">
                        <a href="{{ route('deposit') }}"><i class="fa fa-credit-card"></i> <span
                                class="nav-label">Deposit</span></a>
                    </li>
                    @endcan
                    @can('Ver Task')
                    <li class="{{ Request::is('maintenance') ? 'active' : '' }}">
                        <a href="{{ route('maintenance') }}"><i class="fa fa-cogs"></i> <span
                                class="nav-label">Mantenimiento</span></a>
                    </li>
                    @endcan
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i
                                class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">

                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-clock-o"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="">
                                <div id="dateMenu"></div>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="">
                                <div id="clockMenu"></div>
                            </a>
                        </li>
                        <li class="dropdown">
                            @if ($rouletteSpin > 0)
                            <button type="button" class="btn btn-w-m btn-primary" data-toggle="modal"
                                data-target="#myModal5">Ruleta {{ $rouletteSpin }}</button>
                            @endif
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <img alt="image" class="rounded-circle"
                                    src="{{  asset($dataUser->img) ?: asset('img/logo/basic_logo.png') }}"
                                    style="width: 40px; height: auto; max-width: 100%;" />
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item"
                                        href="{{ route('perfilUsuario', ['id' => Auth::user()->id]) }}">Perfil</a></li>
                                <li><a class="dropdown-item" href="">Manuales</a></li>
                                <li><a class="dropdown-item" href="">Correos</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ Route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-bell"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                @yield('content')
            </div>

            <div class="footer">
                <div class="float-right">
                    10GB of <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> Inforad 2024
                </div>
            </div>
        </div>

        <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Gira y Gana</h4>
                        <small class="font-bold"></small>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center">
                        <div id="mainbox" class="mainbox">
                            <div id="mainbox-2" class="mainbox">
                                <div id="box" class="box">
                                    <div class="box1">
                                        @foreach ($premios1 as $premio)
                                        <span class="span{{ $premio->order }}"><b class="white">{{ $premio->name
                                                }}</b></span>
                                        @endforeach
                                    </div>
                                    <div class="box2">
                                        @foreach ($premios2 as $premio)
                                        <span class="span{{ $premio->order }}"><b>{{ $premio->name }}</b></span>
                                        @endforeach
                                    </div>

                                </div>
                                <img class="spin" src="{{asset('ruleta/es_wheel-spin-logo.png')}}" onclick="giro()"
                                    alt="">
                            </div>

                            <div>
                                <div id="sonido" style="display: none;">
                                    <iframe src="{{asset('ruleta/sonido/ruleta.mp3')}}" id="audio"></iframe>
                                </div>
                            </div>

                            {{-- <div>
                                <div id="sonido" style="display: none;">
                                    <iframe src="sonido/ruleta.mp3" id="audio"></iframe>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footerimport')
</body>
</html>
