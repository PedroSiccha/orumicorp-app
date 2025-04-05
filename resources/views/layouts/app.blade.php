<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Datrux - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="wrapper">

        @include('partials.sidebar')

        <div id="page-wrapper" class="gray-bg">
            @include('partials.navbar')
            <div class="wrapper wrapper-content animated fadeInRight">
                @yield('content')
            </div>
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
