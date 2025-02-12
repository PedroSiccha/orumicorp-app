function sendMessage(uuid, phone, inputMessage) {
    var message = $(inputMessage).val();
    $.post(sendMessageRoute, { uuid: uuid, phone: phone, message: message, _token: token })
        .done(function(data) {
            console.log("DAta " + data.message.status);
            console.log("DAta " + data);
            if (data.message.status === 'enqueued') {
                $(inputMessage).val("");
            }
            verDetalleChat(uuid, phone);
        })
        .fail(function() {
            $(inputMessage).val("");
        });
        verDetalleChat(uuid, phone);
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
