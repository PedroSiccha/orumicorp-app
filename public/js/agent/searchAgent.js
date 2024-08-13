function searchAgent(inputcodeVoiso, inputName) {
    var codeVoiso = $(inputcodeVoiso).val();
    $.post(searchAgentRoute, {codeVoiso: codeVoiso, _token: token}).done(function(data) {
        $(inputName).val(data.name);
    });
}
