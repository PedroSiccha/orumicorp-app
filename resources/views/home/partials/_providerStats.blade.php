{{-- resources/views/home/partials/_providerStats.blade.php --}}
<div class="row">

    {{-- Clientes Registrados --}}
    <div class="col-lg-4">
        <div class="ibox">
            <div class="ibox-title">
                <span class="label label-success float-right">
                    {{ \Carbon\Carbon::now()->translatedFormat('F') }}
                </span>
                <h5>Clientes Registrados</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $cantClientsRegisterProvider }}</h1>
                <div class="stat-percent font-bold text-success">
                    {{ $percentClientsRegisterProvider }}% <i class="fa fa-users"></i>
                </div>
                <small>Total Clientes</small>
            </div>
        </div>
    </div>

    {{-- Clientes Activados --}}
    <div class="col-lg-4">
        <div class="ibox">
            <div class="ibox-title">
                <span class="label label-info float-right">
                    {{ \Carbon\Carbon::now()->translatedFormat('F') }}
                </span>
                <h5>Clientes Activados</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $cantClientsActiveProvider }}</h1>
                <div class="stat-percent font-bold text-info">
                    {{ $percentClientsActiveProvider }}% <i class="fa fa-check"></i>
                </div>
                <small>Clientes Activos</small>
            </div>
        </div>
    </div>

    {{-- Clientes Anuales --}}
    <div class="col-lg-4">
        <div class="ibox">
            <div class="ibox-title">
                <span class="label label-warning float-right">
                    {{ \Carbon\Carbon::now()->year }}
                </span>
                <h5>Clientes Anuales</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $cantClientsProvider }}</h1>
                <div class="stat-percent font-bold text-warning">
                    <i class="fa fa-calendar"></i>
                </div>
                <small>Registro de clientes durante el año</small>
            </div>
        </div>
    </div>

</div>
