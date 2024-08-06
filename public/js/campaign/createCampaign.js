function createCampaign(options) {
    var name = options.nameCampaign !== undefined ? $(options.nameCampaign).val() : '';
    var description = options.descriptionCampaign !== undefined ? $(options.descriptionCampaign).val() : '';
    var startDate = options.initDateCampaign !== undefined ? $(options.initDateCampaign).val() : '';
    var endDate = options.endDateCampaign !== undefined ? $(options.endDateCampaign).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    $.post(saveCampaignRoute, {name: name, description: description,  startDate: startDate, endDate: endDate, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.nameCampaign).val('');
        $(options.descriptionCampaign).val('');
        $(options.endDateCampaign).val('');
        $(options.initDateCampaign).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
