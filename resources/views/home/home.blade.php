{{-- resources/views/home/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Inicio')

@section('content')

    @if(auth()->user()->hasRole('PROVEEDOR'))
        @include('home.partials._providerStats')
    @endif

    @includeWhen(
        Gate::allows('Ver Ventas Tablero') ||
        Gate::allows('Ver Cantidad Agentes Tablero') ||
        Gate::allows('Ver Cantidad Clientes Tablero'),
        'home.partials._ventasStats'
    )

    @can('Estadistica de Ventas')
        @include('home.partials._chartVentas')
    @endcan

    @can('Rankig de Ventas Tablero')
        @include('home.partials._rankingVentas')
    @endcan

    @if(auth()->check() && !auth()->user()->hasRole('PROVEEDOR'))
        @include('home.partials._modalAsistencia')
    @endif

    @include('cliente.modal.modalChargeGroup')

@endsection
