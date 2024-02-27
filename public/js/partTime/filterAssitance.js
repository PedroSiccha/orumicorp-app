function filterAssitance(dateInit, dateEnd) {
    $.post(filterAssitanceRoute, {dateInit: dateInit, dateEnd: dateEnd, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
    });
}
