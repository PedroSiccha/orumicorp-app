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
        <link href="{{asset('ruleta/styles.css')}}" rel="stylesheet">
    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="{{ route('home') }}">
                                    <img alt="image" class="rounded" src="{{asset('img/logo/logo_horizontal_ab.png')}}" width="90%" height="90%"/>
                                </a>
                            </div>
                            <div class="logo-element">
                                <img alt="image" class="rounded-circle" src="{{asset('img/logo/basic_logo.png')}}" width="50%" height="50%"/>
                            </div>
                        </li>

                        <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> <span class="nav-label">Tablero</span> </a>
                        </li>

                        @can('Ver Agentes')
                        <li class="{{ Request::is('agents') ? 'active' : '' }}">
                            <a href="{{ route('agents') }}"><i class="fa fa-user-o"></i> <span class="nav-label">Agentes</span></a>
                        </li>
                        @endcan
                        @can('Ver Area')
                        <li class="{{ Request::is('areas') ? 'active' : '' }}">
                            <a href="{{ route('areas') }}"><i class="fa fa-user-o"></i> <span class="nav-label">Áreas</span></a>
                        </li>
                        @endcan
                        @can('Ver Cliente')
                        <li class="{{ Request::is('clients') ? 'active' : '' }}">
                            <a href="{{ route('clients') }}"><i class="fa fa-user-o"></i> <span class="nav-label">Clientes</span></a>
                        </li>
                        @endcan
                        @can('Ver Ventas')
                        <li class="{{ Request::is('sales') ? 'active' : '' }}">
                            <a href="{{ route('sales') }}"><i class="fa fa-file-text-o"></i> <span class="nav-label">Ventas</span></a>
                        </li>
                        @endcan
                        @can('Ver Bonus')
                        <li class="{{ Request::is('agentbonus') ? 'active' : '' }}">
                            <a href="{{ route('agentBonus') }}"><i class="fa fa-dot-circle-o"></i> <span class="nav-label">Bonus agente </span></a>
                        </li>
                        @endcan
                        @can('Ver Today')
                        <li class="{{ Request::is('statisticstoday') ? 'active' : '' }}">
                            <a href="{{ route('statisticsToday') }}"><i class="fa fa-bar-chart"></i> <span class="nav-label">Today Statistic</span></a>
                        </li>
                        @endcan
                        @can('Ver Gestión Ruleta')
                        <li class="{{ Request::is('gestionRuleta') ? 'active' : '' }}">
                            <a href="{{ route('gestionRuleta') }}"><i class="fa fa-bar-chart"></i> <span class="nav-label">Gestión de Ruleta</span></a>
                        </li>
                        @endcan
                        @can('Ver Part Time')
                        <li class="{{ Request::is('parttime') ? 'active' : '' }}">
                            <a href="{{ route('partTime') }}"><i class="fa fa-clock-o"></i> <span class="nav-label">Part Time</span></a>
                        </li>
                        @endcan
                        @can('Ver Seguridad')
                        <li class="{{ Request::is('security') ? 'active' : '' }}">
                            <a href="{{ route('security') }}"><i class="fa fa-lock"></i> <span class="nav-label">Seguridad</span></a>
                        </li>
                        @endcan
                        @can('Ver Auditoria')
                        <li class="{{ Request::is('audit') ? 'active' : '' }}">
                            <a href="{{ route('audit') }}"><i class="fa fa-warning"></i> <span class="nav-label">Auditoria</span></a>
                        </li>
                        @endcan
                        @can('Ver Task')
                        <li class="{{ Request::is('task') ? 'active' : '' }}">
                            <a href="{{ route('task') }}"><i class="fa fa-calendar"></i> <span class="nav-label">Task</span></a>
                        </li>
                        @endcan
                        @can('Ver Task')
                        <li class="{{ Request::is('whatsapp') ? 'active' : '' }}">
                            <a href="{{ route('whatsapp') }}"><i class="fa fa-comments-o"></i> <span class="nav-label">Whatsapp</span></a>
                        </li>
                        @endcan
                        {{-- @can('Ver Task')
                        <li class="{{ Request::is('email') ? 'active' : '' }}">
                            <a href="{{ route('email') }}"><i class="fa fa-envelope-o"></i> <span class="nav-label">Email</span></a>
                        </li>
                        @endcan --}}
                        @can('Ver Task')
                        <li class="{{ Request::is('shooter') ? 'active' : '' }}">
                            <a href="{{ route('shooter') }}"><i class="fa fa-superpowers"></i> <span class="nav-label">Shooter</span></a>
                        </li>
                        @endcan
                        @can('Ver Task')
                        <li class="{{ Request::is('deposit') ? 'active' : '' }}">
                            <a href="{{ route('deposit') }}"><i class="fa fa-credit-card"></i> <span class="nav-label">Deposit</span></a>
                        </li>
                        @endcan
                        {{-- @can('Ver Task')
                        <li class="{{ Request::is('maintenance') ? 'active' : '' }}">
                            <a href="{{ route('maintenance') }}"><i class="fa fa-cogs"></i> <span class="nav-label">Mantenimiento</span></a>
                        </li>
                        @endcan --}}
                    </ul>
                </div>
            </nav>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
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
                                    <button type="button" class="btn btn-w-m btn-primary" data-toggle="modal" data-target="#myModal5">Ruleta {{ $rouletteSpin }}</button>
                                @endif
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    <img alt="image" class="rounded-circle" src="{{  asset($dataUser->img) ?: asset('img/logo/basic_logo.png') }}" style="width: 40px; height: auto; max-width: 100%;"/>
                                </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                        <li><a class="dropdown-item" href="{{ route('perfilUsuario', ['id' => Auth::user()->id]) }}">Perfil</a></li>
                                        <li><a class="dropdown-item" href="">Manuales</a></li>
                                        <li><a class="dropdown-item" href="">Correos</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ Route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
                <div class="wrapper wrapper-content">
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

            <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Gira y Gana</h4>
                            <small class="font-bold"></small>
                        </div>
                        <div class="modal-body d-flex align-items-center justify-content-center">
                            <div id="mainbox" class="mainbox">
                                <div id="mainbox" class="mainbox">
                                    <div id="box" class="box">
                                        <div class="box1">
                                            @foreach ($premios1 as $premio)
                                                <span class="span{{ $premio->order }}"><b class="white">{{ $premio->name }}</b></span>
                                            @endforeach
                                        </div>
                                        <div class="box2">
                                            @foreach ($premios2 as $premio)
                                                <span class="span{{ $premio->order }}"><b>{{ $premio->name }}</b></span>
                                            @endforeach
                                        </div>

                                    </div>
                                    <img class="spin" src="{{asset('ruleta/es_wheel-spin-logo.png')}}" onclick="giro()" alt="">
                                </div>

                                <div>
                                    <div id="sonido" style="display: none;">
                                        <iframe src="{{asset('ruleta/sonido/ruleta.mp3')}}" id="audio"></iframe>
                                    </div>
                                </div>

                                <div>
                                    <div id="sonido" style="display: none;">
                                        <iframe src="sonido/ruleta.mp3" id="audio"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
        <script src="{{ asset('js/utils/updateClockMenu.js') }}"></script>
        <script src="{{ asset('js/utils/dateMenu.js') }}"></script>
        <script src="{{ asset('js/task/task.js') }}" defer></script>
        <!-- Mainly scripts -->
        <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
        <script src="{{asset('js/popper.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.js')}}"></script>
        <script src="{{asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
        <script src="{{asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

        <!-- Flot -->
        <script src="{{asset('js/plugins/flot/jquery.flot.js')}}"></script>
        <script src="{{asset('js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
        <script src="{{asset('js/plugins/flot/jquery.flot.spline.js')}}"></script>
        <script src="{{asset('js/plugins/flot/jquery.flot.resize.js')}}"></script>
        <script src="{{asset('js/plugins/flot/jquery.flot.pie.js')}}"></script>
        <script src="{{asset('js/plugins/flot/jquery.flot.symbol.js')}}"></script>
        <script src="{{asset('js/plugins/flot/jquery.flot.time.js')}}"></script>
        <script src="{{ asset('js/plugins/flot/curvedLines.js') }}"></script>

        <!-- Peity -->
        <script src="{{asset('js/plugins/peity/jquery.peity.min.js')}}"></script>
        <script src="{{asset('js/demo/peity-demo.js')}}"></script>

        <!-- Custom and plugin javascript -->
        <script src="{{asset('js/inspinia.js')}}"></script>
        <script src="{{asset('js/plugins/pace/pace.min.js')}}"></script>

        <!-- jQuery UI -->
        <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

        <!-- Jvectormap -->
        <script src="{{asset('js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
        <script src="{{asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

        <!-- EayPIE -->
        <script src="{{asset('js/plugins/easypiechart/jquery.easypiechart.js')}}"></script>

        <!-- Sparkline -->
        <script src="{{asset('js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

        <!-- Sparkline demo data  -->
        <script src="{{asset('js/demo/sparkline-demo.js')}}"></script>
        <script src="{{asset('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

        <script src="{{ asset('js/plugins/ladda/spin.min.js') }}"></script>
        <script src="{{ asset('js/plugins/ladda/ladda.min.js') }}"></script>
        <script src="{{ asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>

        <!-- FooTable -->
        <script src="{{asset('js/plugins/footable/footable.all.min.js')}}"></script>
        <script src="{{ asset('js/rouletteManagement/updateGiro.js') }}"></script>
        <script src="{{ asset('js/rouletteManagement/getPremio.js') }}"></script>
        <script src="{{asset('js/ruleta.js')}}"></script>
        <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
        <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>

        @yield('script')
        <script>
            var updateGiroRoute = '{{ route("updateGiro") }}';
            var getPremioRoute = '{{ route("getPremio") }}';
            var token = '{{ csrf_token() }}';
            $(document).ready(function() {

                $('#date_added').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                });

                $('.chart').easyPieChart({
                    barColor: '#f8ac59',
                    scaleLength: 5,
                    lineWidth: 4,
                    size: 80
                });

                $('.chart2').easyPieChart({
                    barColor: '#1c84c6',
                    scaleLength: 5,
                    lineWidth: 4,
                    size: 80
                });

                var data2 = [
                    [gd(2012, 1, 1), 7], [gd(2012, 1, 2), 6], [gd(2012, 1, 3), 4], [gd(2012, 1, 4), 8],
                    [gd(2012, 1, 5), 9], [gd(2012, 1, 6), 7], [gd(2012, 1, 7), 5], [gd(2012, 1, 8), 4],
                    [gd(2012, 1, 9), 7], [gd(2012, 1, 10), 8], [gd(2012, 1, 11), 9], [gd(2012, 1, 12), 6],
                    [gd(2012, 1, 13), 4], [gd(2012, 1, 14), 5], [gd(2012, 1, 15), 11], [gd(2012, 1, 16), 8],
                    [gd(2012, 1, 17), 8], [gd(2012, 1, 18), 11], [gd(2012, 1, 19), 11], [gd(2012, 1, 20), 6],
                    [gd(2012, 1, 21), 6], [gd(2012, 1, 22), 8], [gd(2012, 1, 23), 11], [gd(2012, 1, 24), 13],
                    [gd(2012, 1, 25), 7], [gd(2012, 1, 26), 9], [gd(2012, 1, 27), 9], [gd(2012, 1, 28), 8],
                    [gd(2012, 1, 29), 5], [gd(2012, 1, 30), 8], [gd(2012, 1, 31), 25]
                ];

                var data3 = [
                    [gd(2012, 1, 1), 800], [gd(2012, 1, 2), 500], [gd(2012, 1, 3), 600], [gd(2012, 1, 4), 700],
                    [gd(2012, 1, 5), 500], [gd(2012, 1, 6), 456], [gd(2012, 1, 7), 800], [gd(2012, 1, 8), 589],
                    [gd(2012, 1, 9), 467], [gd(2012, 1, 10), 876], [gd(2012, 1, 11), 689], [gd(2012, 1, 12), 700],
                    [gd(2012, 1, 13), 500], [gd(2012, 1, 14), 600], [gd(2012, 1, 15), 700], [gd(2012, 1, 16), 786],
                    [gd(2012, 1, 17), 345], [gd(2012, 1, 18), 888], [gd(2012, 1, 19), 888], [gd(2012, 1, 20), 888],
                    [gd(2012, 1, 21), 987], [gd(2012, 1, 22), 444], [gd(2012, 1, 23), 999], [gd(2012, 1, 24), 567],
                    [gd(2012, 1, 25), 786], [gd(2012, 1, 26), 666], [gd(2012, 1, 27), 888], [gd(2012, 1, 28), 900],
                    [gd(2012, 1, 29), 178], [gd(2012, 1, 30), 555], [gd(2012, 1, 31), 993]
                ];


                var dataset = [
                    {
                        label: "Number of orders",
                        data: data3,
                        color: "#1ab394",
                        bars: {
                            show: true,
                            align: "center",
                            barWidth: 24 * 60 * 60 * 600,
                            lineWidth:0
                        }

                    }, {
                        label: "Payments",
                        data: data2,
                        yaxis: 2,
                        color: "#1C84C6",
                        lines: {
                            lineWidth:1,
                                show: true,
                                fill: true,
                            fillColor: {
                                colors: [{
                                    opacity: 0.2
                                }, {
                                    opacity: 0.4
                                }]
                            }
                        },
                        splines: {
                            show: false,
                            tension: 0.6,
                            lineWidth: 1,
                            fill: 0.1
                        },
                    }
                ];


                var options = {
                    xaxis: {
                        mode: "time",
                        tickSize: [3, "day"],
                        tickLength: 0,
                        axisLabel: "Date",
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 12,
                        axisLabelFontFamily: 'Arial',
                        axisLabelPadding: 10,
                        color: "#d5d5d5"
                    },
                    yaxes: [{
                        position: "left",
                        max: 1070,
                        color: "#d5d5d5",
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 12,
                        axisLabelFontFamily: 'Arial',
                        axisLabelPadding: 3
                    }, {
                        position: "right",
                        clolor: "#d5d5d5",
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 12,
                        axisLabelFontFamily: ' Arial',
                        axisLabelPadding: 67
                    }
                    ],
                    legend: {
                        noColumns: 1,
                        labelBoxBorderColor: "#000000",
                        position: "nw"
                    },
                    grid: {
                        hoverable: false,
                        borderWidth: 0
                    }
                };

                function gd(year, month, day) {
                    return new Date(year, month - 1, day).getTime();
                }

                var previousPoint = null, previousLabel = null;

                $.plot($("#flot-dashboard-chart"), dataset, options);

                var mapData = {
                    "US": 298,
                    "SA": 200,
                    "DE": 220,
                    "FR": 540,
                    "CN": 120,
                    "AU": 760,
                    "BR": 550,
                    "IN": 200,
                    "GB": 120,
                };

                $('#world-map').vectorMap({
                    map: 'world_mill_en',
                    backgroundColor: "transparent",
                    regionStyle: {
                        initial: {
                            fill: '#e4e4e4',
                            "fill-opacity": 0.9,
                            stroke: 'none',
                            "stroke-width": 0,
                            "stroke-opacity": 0
                        }
                    },

                    series: {
                        regions: [{
                            values: mapData,
                            scale: ["#1ab394", "#22d6b1"],
                            normalizeFunction: 'polynomial'
                        }]
                    },
                });
            });
        </script>
    </body>
</html>
