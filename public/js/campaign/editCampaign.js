function editarCampaign(options) {

    var idCampaign = options.idCampaign !== undefined ? options.idCampaign : '';
    var name = options.name !== undefined ? options.name : '';
    var description = options.description !== undefined ? options.description : '';
    var startDate = options.startDate !== undefined ? options.startDate : '';
    var endDate = options.endDate !== undefined ? options.endDate : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var inputId = options.inputId !== undefined ? options.inputId : '';
    var inputName = options.inputName !== undefined ? options.inputName : '';
    var inputDescription = options.inputDescription !== undefined ? options.inputDescription : '';
    var inputStartDate = options.inputStartDate !== undefined ? options.inputStartDate : '';
    var inputEndCampaign = options.inputEndCampaign !== undefined ? options.inputEndCampaign : '';

    $(inputId).val(idCampaign);
    $(inputName).val(name);
    $(inputDescription).val(description);
    $(inputStartDate).val(startDate);
    $(inputEndCampaign).val(endDate);
    $(modal).modal('show');
}

function updateCampaign(options) {
    var id = options.editCampaignId !== undefined ? $(options.editCampaignId).val() : '';
    var name = options.nameCampaign !== undefined ? $(options.nameCampaign).val() : '';
    var description = options.descriptionCampaign !== undefined ? $(options.descriptionCampaign).val() : '';
    var startDate = options.initDateCampaign !== undefined ? $(options.initDateCampaign).val() : '';
    var endDate = options.endDateCampaign !== undefined ? $(options.endDateCampaign).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    $.post(updateCampaignRoute, {id: id, name: name, description: description, startDate: startDate, endDate: endDate, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.editCampaignId).val('');
        $(options.nameCampaign).val('');
        $(options.descriptionCampaign).val('');
        $(options.initDateCampaign).val('');
        $(options.endDateCampaign).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
