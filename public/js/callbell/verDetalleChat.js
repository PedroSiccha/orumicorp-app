function verDetalleChat(uuid, phone) {
    $.post(getChatDetailsRoute, { uuid: uuid, _token: token })
        .done(function(data) {
            if (data.messages) {
                let messagesHtml = '';
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
                $('#chat-messages').html(messagesHtml);  // Assuming #chat-messages is the container for messages
            }
        })
        .fail(function() {
            alert('Error al obtener los detalles del chat');
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

