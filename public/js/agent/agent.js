function guardarNuevoAgente(inputCode, inputName, inputLastname, inputCodeVoiso, inputEmail, inputAreaId, inputRolId, modal, tableName) {

    var code = $(inputCode).val();
    var name = $(inputName).val();
    var lastname = $(inputLastname).val();
    var codeVoiso = $(inputCodeVoiso).val();
    var email = $(inputEmail).val();
    var area_id = $(inputAreaId).val();
    var rol_id = $(inputRolId).val();

    $.post(saveAgentRoute, {code:code, name: name, lastname: lastname, codeVoiso: codeVoiso, email: email, area_id: area_id, rol_id: rol_id, _token: token}).done(function(data) {

        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);

        // $('#modalAgente').modal('hide');
        // $("#tabAgente").empty();
        // $("#tabAgente").html(data.view);
        // if (data.resp == 1) {

        //     Swal.fire({
        //         title: "Guardado",
        //         text: "El agente se guardó correctamente",
        //         icon: "success"
        //     });

        // } else {

        //     Swal.fire({
        //         title: "Guardado",
        //         text: "El agente no pudo ser guardado",
        //         icon: "error"
        //     });

        // }

    });

}
