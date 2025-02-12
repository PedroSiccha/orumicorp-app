function getPremio(premio) {
    $.post(getPremioRoute, {premio: premio, _token: token}).done(function(data) {
        location.reload();
    });
}
