<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datrux - @yield('title')</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('js/calendar/style.css') }}">
    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <div id="wrapper">
        {{-- Sidebar --}}
        @include('partials.sidebar')
        <div id="page-wrapper" class="gray-bg">
            {{-- Navbar --}}
            @include('partials.navbar')

            {{-- Contenido dinámico --}}
            <div class="wrapper wrapper-content animated fadeInRight">
                @yield('content')
            </div>

            {{-- Footer --}}
            @include('partials.footer')
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

                        </div>
                    </div>

                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        @include('cliente.modal.modalCrearComentario')
    </div>
    @include('layouts.footerimport')
</body>
</html>
