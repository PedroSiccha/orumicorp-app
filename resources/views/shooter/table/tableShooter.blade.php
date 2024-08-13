<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-md-12">

            <div class="ibox">
                <div class="ibox-title">
                    {{-- <span class="float-right">(<strong>5</strong>) items</span> --}}
                    <h5>Clientes Pendientes</h5>
                </div>

                @foreach ($clients as $client)
                <div class="ibox-content">


                    <div class="table-responsive">
                        <table class="table shoping-cart-table">

                            <tbody>
                            <tr>
                                <td width="90">
                                    <div class="cart-product-imitation">
                                    </div>
                                </td>
                                <td class="desc">
                                    <h3>
                                    <a href="#" class="text-navy">
                                        {{ $client->name }} {{ $client->lastname }}
                                    </a>
                                    </h3>
                                    <p class="small">
                                        @if ($client->latestComunication)
                                            {{$client->latestComunication->comment}}
                                        @else
                                            Sin Comentario
                                        @endif
                                    </p>
                                    <dl class="small m-b-none">
                                        <dt>Dirección</dt>
                                        <dd>{{ $client->country }}, {{ $client->city }}</dd>
                                    </dl>

                                    <div class="m-t-sm">
                                        @if ($client->latestCampaign)
                                            {{-- <a href="#" class="text-muted"><i class="fa fa-gift"></i> {{ $client->latestCampaign->name }}</a> --}}
                                        @endif

                                        |
                                        @if ($client->latestSupplier)
                                            {{-- <a href="#" class="text-muted"><i class="fa fa-trash"></i> {{ $client->latestSupplier->name }}</a> --}}
                                        @endif

                                    </div>
                                </td>

                                <td>
                                    <button class="btn btn-primary float-right" onclick="initiateCall({phone: '{{ $client->phone }}', modal: '#modalCrearComentario', input: '#idComunication'})"><h3><i class="fa fa-phone"></i> {{ $client->phone }}</h3></button>
                                    {{-- <h3 class="table-active navy-bg"><i class="fa fa-phone"></i> {{ $client->phone }}</h3> --}}
                                </td>
                                <td>
                                    <h4>
                                        <button class="btn btn-warning" onclick="initiateCall({phone: '{{ $client->phone }}', modal: '#modalCrearComentario', input: '#idComunication'})"><i class="fa fa-phone"></i> {{ $client->optional_phone }}</button>
                                    </h4>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                @endforeach
            </div>

        </div>
    </div>




</div>
