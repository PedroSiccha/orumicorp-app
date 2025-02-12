function filterStatistics(inputArea, inputDateInit, inputDateEnd, tableName) {
    var area = $(inputArea).val();
    var dateInit = $(inputDateInit).val();
    var dateEnd = $(inputDateEnd).val();
    $.post(filterStatisticsRoute, {area: area, dateInit: dateInit,  dateEnd: dateEnd, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
    });
}
