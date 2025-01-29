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
            <div class="ibox-title d-flex justify-content-between align-items-center">
                <h5>Clientes</h5>
                <input type="text" id="search-phone" class="form-control form-control-sm" placeholder="Buscar por teléfono">
                <button id="search-button" class="btn btn-primary btn-sm">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <div class="ibox-content">
                <div id="loading-indicator" style="display: none; text-align: center;">
                    <img src="https://i.gifer.com/VAyR.gif" alt="Cargando..." width="50" height="50">
                </div>
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
                                <small class="text-muted">{{ $contact['assignedUser'] }}</small>
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 id="chat-client-name">Cliente</h5>
                <button class="btn btn-success btn-sm" onclick="iniciarNuevoMensaje()">
                    <i class="fa fa-plus"></i> Nuevo Mensaje
                </button>
            </div>
            <div class="card-body" id="chat-messages">
                <!-- Aquí se cargarán los mensajes del chat -->
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
<script>
    var getChatDetailsRoute = '{{ route("getChatDetails") }}';
    var sendMessageRoute = '{{ route("sendMessage") }}';
    var searchContactRoute = '{{ route("searchContact") }}';
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

    function submitMessage() {
        const message = document.getElementById('inputMessage').value;
        const phone = document.getElementById('inputPhone').value;
        const uuid = document.getElementById('inputUuid').value;

        if (message.trim() === "" || phone.trim() === "") {
            alert('El mensaje o el número de teléfono no pueden estar vacíos.');
            return;
        }

        fetch("{{ route('sendMessage') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ phone, message })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);

            if (data.message.status === 'enqueued') {
                document.getElementById('inputMessage').value = "";
                // alert('Mensaje enviado con éxito');
            } else {
                document.getElementById('inputMessage').value = "";
                // alert('Error al enviar el mensaje. Inténtalo de nuevo.');
            }
            if (!uuid) {
                location.reload();
            } else {
                verDetalleChat(uuid, phone);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('inputMessage').value = "";
            // alert('Hubo un problema al enviar el mensaje.');
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        markNotificationsAsSeen('whatsapp');
    });
</script>
@endsection
