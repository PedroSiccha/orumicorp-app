<div id="contact-1" class="tab-pane active">
    <div class="row m-b-lg">
        <div class="col-lg-4 text-center">
            <h2>{{ $client->name }} {{ $client->name }}</h2>

            <div class="m-b-sm">
                <img alt="image" class="rounded-circle" src="img/a2.jpg" style="width: 62px">
            </div>
        </div>
        <div class="col-lg-8">
            <strong>
                Ultimo Comentario
            </strong>

            <p>
                @if ($client->latestComunication)
                    {{ $client->latestComunication->comment }}
                @else
                    Sin Comentario
                @endif
            </p>
            @can('Llamadas VOISO')
            @if ($client->phone)
                <button type="button" class="btn btn-info btn-sm btn-block"><i class="fa fa-phone"></i> </button>
            @endif
            @endcan
        </div>
    </div>
    <div class="client-detail">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">

        <strong>Datos</strong>

        <ul class="list-group clear-list">
            @if ($client->latestAssignamet)
                <li class="list-group-item fist-item">
                    <span class="float-right"> {{ $client->latestAssignamet->agent->name }} {{ $client->latestAssignamet->agent->lastname }} </span>
                    Agente Asignado
                </li>
            @endif
            @if ($client->statusCustomer)
                <li class="list-group-item">
                    <span class="float-right"> {{ $client->statusCustomer->name }} </span>
                    Estado
                </li>
            @endif
            @if ($client->traiding)
                <li class="list-group-item">
                    <span class="float-right"> {{ $client->traiding->code }} </span>
                    Código de Traiding
                </li>
            @endif

        </ul>
        <hr>
        <strong>Llamadas</strong>
        <div id="vertical-timeline" class="vertical-container dark-timeline">
            @foreach ($comunications as $comunication)
                <div class="vertical-timeline-block">
                    <div class="vertical-timeline-icon gray-bg">
                        <i class="fa fa-phone"></i>
                    </div>
                    <div class="vertical-timeline-content">
                        <p>{{ $comunication->tipo }}
                        </p>
                        <span class="vertical-date small text-muted"> {{ $comunication->date->format('d/m/Y H:i:s') }} </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 405.913px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
    </div>
</div>
