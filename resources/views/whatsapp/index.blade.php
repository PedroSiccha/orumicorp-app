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
                    <div class="feed-activity-list" id="contacts-list">
                        @foreach ($contacts as $contact)
                        <div class="feed-element" onclick="verDetalleChat('{{ $contact['uuid'] }}', '{{ $contact['phoneNumber'] }}')">
                            <a href="#" class="float-left">
                                <img alt="image" class="rounded-circle mr-3" src="{{ $contact['avatarUrl'] ?? 'img/logo/basic_logo.png' }}" width="40" height="40">
                                @if ($contact['source'] === 'whatsapp')
                                    <img alt="overlay" class="overlay-icon" style="" src="img/logo/whatsappicon.png" width="20" height="20">
                                @else
                                    <img alt="overlay" class="overlay-icon" style="" src="img/logo/telegramicon.png" width="20" height="20">
                                @endif
                            </a>
                            <div class="media-body ">
                                <small class="float-right">{{ $contact['createdAt'] }}</small>
                                <strong>{{ $contact['name'] }}</strong>. <br>
                                <small class="text-muted">{{ $contact['phoneNumber'] }} - {{ $contact['assignedUser'] }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <button id="load-more" class="btn btn-primary btn-block m"><i class="fa fa-arrow-down"></i> Ver Más</button>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8" id="chat-details">
        <div class="card">
            <div class="card-header">
                <h5 id="chat-client-name">Cliente</h5>
            </div>
            <div class="card-body" id="chat-messages">
                <!-- Aquí se cargarán los mensajes del chat -->
            </div>
            <div class="mt-3">
                <form>
                    <div class="input-group">
                        <input id="inptuMessage" type="text" class="form-control" placeholder="Escribe tu mensaje...">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="sendMessage('', '', '')">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
<script>
    var getChatDetailsRoute = '{{ route("getChatDetails") }}';
    var sendMessageRoute = '{{ route("sendMessage") }}';
</script>

<script src="{{asset('js/callbell/verDetalleChat.js')}}"></script>
<script src="{{asset('js/callbell/sendMessage.js')}}"></script>
<script>
    var baseUrl = '{{ $baseUrl }}';
    var token_bearer = '{{ $token }}';
    let page = 1;

    document.getElementById('load-more').addEventListener('click', function() {
        page++;
        fetchContacts(page);
    });

    function fetchContacts(page) {
        fetch(`/whatsapp?page=${page}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.contacts.length > 0) {
                const contactsList = document.getElementById('contacts-list');
                data.contacts.forEach(contact => {
                    const contactElement = document.createElement('div');
                    contactElement.className = 'feed-element';
                    contactElement.innerHTML = `
                        <a href="#" class="float-left">
                            <img alt="image" class="rounded-circle mr-3" src="${contact.avatarUrl ?? 'img/logo/basic_logo.png'}" width="40" height="40">
                            @if ($contact['source'] === 'whatsapp')
                                <img alt="overlay" class="overlay-icon" style="" src="img/logo/whatsappicon.png" width="20" height="20">
                            @else
                                <img alt="overlay" class="overlay-icon" style="" src="img/logo/telegramicon.png" width="20" height="20">
                            @endif
                        </a>
                        <div class="media-body">
                            <small class="float-right">${contact.createdAt}</small>
                            <strong>${contact.name}</strong><br>
                            <small class="text-muted">${contact.phoneNumber} - ${contact.assignedUser}</small>
                        </div>
                    `;
                    contactsList.appendChild(contactElement);
                });
            } else {
                document.getElementById('load-more').disabled = true;
                document.getElementById('load-more').innerText = 'No hay más contactos';
            }
        })
        .catch(error => console.error('Error al cargar más contactos:', error));
    }
</script>
@endsection
