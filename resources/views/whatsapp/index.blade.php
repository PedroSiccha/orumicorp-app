@extends('layouts.app')
@section('title')
    Whatsapp
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Whatsapp</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>
                    Whatsapp
                </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Clientes</h5>
            </div>
            <div class="ibox-content">
                <div>
                    <div class="feed-activity-list">

                        @foreach ($contacts as $contact)
                        <div class="feed-element" onclick="">
                            <a href="#" class="float-left">
                                <img alt="image" class="rounded-circle mr-3" src="{{ $contact['avatarUrl'] ?? 'img/logo/basic_logo.png' }}" width="40" height="40">
                            </a>
                            <div class="media-body ">
                                <small class="float-right">{{ $contact['createdAt'] }}</small>
                                <strong>{{ $contact['name'] }}</strong>. <br>
                                <small class="text-muted">{{ $contact['phoneNumber'] }} - {{ $contact['assignedUser'] }}</small>
                                {{-- <div class="well">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                    Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                </div> --}}
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <button class="btn btn-primary btn-block m"><i class="fa fa-arrow-down"></i> Ver Más</button>

                </div>

            </div>
        </div>

    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Cliente 01</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-start mb-2">
                        <div class="bg-light p-3 rounded position-relative">
                            <h5 class="mb-1">Mensaje 01</h5>
                            <div class="position-absolute" style="bottom: 5px; right: 10px;">
                                <small class="text-muted">98%</small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-2">
                        <div class="bg-primary text-white p-3 rounded position-relative">
                            <h5 class="mb-1">Mensaje 02</h5>
                            <div class="position-absolute" style="bottom: 5px; right: 10px;">
                                <small>24%</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Escribe tu mensaje...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



</div>
@endsection
