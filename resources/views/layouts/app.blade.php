<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link rel="stylesheet" href="{{ asset('css/roulette.css') }}">
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

        <div id="celebration" class="hidden">
            <div class="celebration-content">
                <h1 id="winner-message">🎉 ¡Ganaste! 🎉</h1>
                <button onclick="closeCelebration()">Aceptar</button>
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
                            <div id="roulette-container">
                                <div id="pointer"></div>
                                <canvas id="roulette" width="400" height="400"></canvas>
                                <button id="spinButton">🎰 Girar</button>
                            </div> 
                                                                                
                            <div id="celebration" class="hidden">
                                <div class="celebration-content">
                                    <h1 id="winner-message">🎉 ¡Ganaste! 🎉</h1>
                                    <button onclick="closeCelebration()">Aceptar</button>
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
