function filterAgent(inputArea, inputCode, inputDateInit, inputDateEnd, tableName) {
    var area = $(inputArea).val();
    var dateInit = $(inputDateInit).val();
    var dateEnd = $(inputDateEnd).val();
    var code = $(inputCode).val();
    $.post(filterAgentRoute, {area: area, code: code, dateInit: dateInit,  dateEnd: dateEnd, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
    });
}
