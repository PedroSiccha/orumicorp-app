function verDetalleChat(uuid, phone) {
    $.post(getChatDetailsRoute, { uuid: uuid, _token: token })
        .done(function(data) {
            let messagesHtml = '';

            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(function(message) {
                    let formattedPhoneNumber = formatPhoneNumber(phone);
                    let alignment = message.from === formattedPhoneNumber ? "justify-content-end" : "justify-content-start";
                    let bgClass = message.from === formattedPhoneNumber ? "bg-primary text-white" : "bg-light";

                    messagesHtml += `
                    <div class="d-flex ${alignment} mb-2">
                        <div class="${bgClass} p-3 rounded position-relative">
                            <h5 class="mb-1">${message.text}</h5>
                            <div class="position-absolute" style="bottom: 5px; right: 10px;">
                                <small>${message.createdAt}</small>
                            </div>
                        </div>
                    </div>`;
                });
            } else {
                // Mostrar mensaje si no hay mensajes en la conversación
                messagesHtml = `
                <div class="text-center text-muted mt-3">
                    <p>No hay mensajes en esta conversación.</p>
                </div>`;
            }

            // Agregar los mensajes o el mensaje de "sin mensajes"
            $('#chat-messages').html(messagesHtml);

            // Eliminar cualquier formulario anterior para evitar duplicados
            $('#send-message-form').remove();

            // Agregar el formulario de envío de mensajes con el número de teléfono dinámico
            let messageInputHtml = `
            <div class="mt-3">
                <form id="send-message-form">
                    <div class="input-group">
                        <input id="inputMessage" name="message" type="text" class="form-control" placeholder="Escribe tu mensaje...">
                        <input id="inputPhone" name="phone" type="hidden" value="${phone}">
                        <input id="inputUuid" name="phone" type="hidden" value="${uuid}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="submitMessage()">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>`;

            // Agregar el input de mensaje dentro del chat-details
            $('#chat-details').append(messageInputHtml);
        })
        .fail(function() {
            // Mostrar mensaje de error en la vista
            $('#chat-messages').html(`
                <div class="text-center text-danger mt-3">
                    <p>Error al obtener los detalles del chat. Intenta nuevamente.</p>
                </div>
            `);
        });
}



function formatPhoneNumber(phoneNumber) {
    // If the phone number is already in the correct format, return it as is
    if (/^\d{12}$/.test(phoneNumber)) {
        return phoneNumber;
    }

    // Remove all non-numeric characters
    let formattedNumber = phoneNumber.replace(/\D/g, '');

    // If the number starts with a country code and has the correct length, return it
    if (/^\d{12}$/.test(formattedNumber)) {
        return formattedNumber;
    }

    // Otherwise, handle as needed
    if (formattedNumber.startsWith('00')) {
        formattedNumber = formattedNumber.slice(2);
    }

    return formattedNumber;
}

function iniciarNuevoMensaje() {
    $('#chat-messages').html(`
        <div class="text-center text-muted mt-3">
            <p>Escribe un nuevo mensaje:</p>
        </div>
    `);

    // Eliminar cualquier formulario anterior para evitar duplicados
    $('#send-message-form').remove();

    // Agregar el formulario con el input de número de teléfono y mensaje
    let messageInputHtml = `
    <div class="mt-3">
        <form id="send-message-form">
            <div class="input-group mb-2">
                <input id="inputPhone" name="phone" type="text" class="form-control" placeholder="Número de teléfono">
            </div>
            <div class="input-group">
                <input id="inputMessage" name="message" type="text" class="form-control" placeholder="Escribe tu mensaje...">
                <input id="inputUuid" name="phone" type="hidden" value="000">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="submitMessage()">Enviar</button>
                </div>
            </div>
        </form>
    </div>`;

    // Agregar el formulario al contenedor de chat
    $('#chat-details').append(messageInputHtml);
}

document.getElementById("search-button").addEventListener("click", function() {
    buscarContactoPorTelefono();
});

// Detectar cuando el usuario presiona "Enter" en el input
document.getElementById("search-phone").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault(); // Evitar que el formulario se envíe si está dentro de uno
        buscarContactoPorTelefono();
    }
});

function buscarContactoPorTelefono() {
    let phone = document.getElementById("search-phone").value.trim();
    let loadingIndicator = document.getElementById("loading-indicator");
    let contactsList = document.getElementById("contacts-list");

    loadingIndicator.style.display = "block";
    contactsList.innerHTML = "";

    $.post(searchContactRoute, { phone: phone, _token: token })
        .done(function(data) {
            loadingIndicator.style.display = "none";
            console.log(data);
            if (data.contact) {
                actualizarListaContactos([data.contact]); // Pasamos un array con el contacto
            } else {
                mostrarMensajeNoResultados();
            }
        })
        .fail(function(xhr, status, error) {
            loadingIndicator.style.display = "none";
            console.error('Error al buscar el contacto:', error);
            mostrarMensajeError();
        });
}

function actualizarListaContactos(contactos) {
    let contactosHtml = contactos.map(contact => `
        <div class="feed-element" onclick="verDetalleChat('${contact.uuid}', '${contact.phoneNumber}')">
            <a href="#" class="float-left">
                <img alt="image" class="rounded-circle mr-3" src="${contact.avatarUrl || 'img/logo/basic_logo.png'}" width="40" height="40">
                <img alt="overlay" class="overlay-icon" src="img/logo/whatsappicon.png" width="20" height="20">
            </a>
            <div class="media-body">
                <small class="float-right">${new Date(contact.createdAt).toLocaleDateString()}</small>
                <strong>${contact.customFields?.['user name'] || contact.name}</strong>. <br>
                <small class="text-muted">${contact.assignedUser || 'No asignado'}</small>
            </div>
        </div>
    `).join('');

    document.getElementById('contacts-list').innerHTML = contactosHtml;
    document.getElementById('no-results').classList.add('d-none');
}

function mostrarMensajeNoResultados() {
    document.getElementById('contacts-list').innerHTML = "";
    document.getElementById('no-results').textContent = "No se encontraron resultados.";
    document.getElementById('no-results').classList.remove('d-none');
}

function mostrarMensajeError() {
    document.getElementById('contacts-list').innerHTML = "";
    document.getElementById('no-results').textContent = "Error al obtener los datos.";
    document.getElementById('no-results').classList.remove('d-none');
}

function resetearListaContactos() {
    document.getElementById('contacts-list').innerHTML = `
        @foreach ($contacts as $contact)
        <div class="feed-element" onclick="verDetalleChat('{{ $contact['uuid'] }}', '{{ $contact['phoneNumber'] }}')">
            <a href="#" class="float-left">
                <img alt="image" class="rounded-circle mr-3" src="{{ $contact['avatarUrl'] ?? 'img/logo/basic_logo.png' }}" width="40" height="40">
                <img alt="overlay" class="overlay-icon" src="{{ $contact['source'] === 'whatsapp' ? 'img/logo/whatsappicon.png' : 'img/logo/telegramicon.png' }}" width="20" height="20">
            </a>
            <div class="media-body">
                <small class="float-right">{{ $contact['createdAt'] }}</small>
                <strong>{{ $contact['name'] }}</strong>. <br>
                <small class="text-muted">{{ $contact['assignedUser'] }}</small>
            </div>
        </div>
        @endforeach
    `;
    document.getElementById('no-results').classList.add('d-none');
}
