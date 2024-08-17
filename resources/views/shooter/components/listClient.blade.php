@if ($clients->isNotEmpty())
<span class="text-muted small float-right">Ultima Actualización: <i class="fa fa-clock-o"></i> 2:10 pm -
    12/06/2024</span>
<h2>Clientes</h2>
<div class="input-group">
    <input type="text" placeholder="Buscar cliente " class="input form-control">
    <span class="input-group-append">
        <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
    </span>
</div>
<div class="clients-list">
    <span class="float-right small text-muted">Cant. Clientes: {{ $clients->count() }}</span>
    <ul class="nav nav-tabs">
        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;">
                <div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tbody>
                                @foreach ($clients as $client)
                                <tr onclick="viewResumClient({ clientId: '{{ $client->id }}', tableName: '#detailClientData' })">
                                    <td class="client-avatar"><img alt="image" src="img/a2.jpg"> </td>
                                    <td><a class="client-link">{{ $client->name }} {{ $client->lastname }}</a></td>
                                    <td><i class="fa fa-phone"> </i> {{ $client->phone }}</td>
                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                    <td> {{ $client->email }}</td>
                                    <td class="client-status"><span class="label @if($client->status) label-primary @else label-danger @endif">@if($client->status) Activo @else Inactivo @endif</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="slimScrollBar"
                    style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 366.599px;">
                </div>
                <div class="slimScrollRail"
                    style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
                </div>
            </div>
        </div>
    </div>

</div>
@else
<div class="widget  p-lg text-center">
    <div class="m-b-md">
        <i class="fa fa-files-o fa-4x"></i>
        <h1 class="m-xs">0</h1>
        <h3 class="font-bold no-margins">
            No Data
        </h3>
        {{-- <small>amount</small> --}}
    </div>
</div>
@endif


