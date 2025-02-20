function updateGiro() {
    $.post(updateGiroRoute, {_token: token}).done(function(data) {});
}
