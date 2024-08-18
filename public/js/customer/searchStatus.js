function searchStatus(options) {
    var customerStatusId = options.customerStatusId !== undefined ? $(options.customerStatusId).val(): '';
    var tableName = options.tableName !== undefined ? options.tableName: '';

    $.post(searchStatusRoute, {customerStatusId: customerStatusId, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
    });
}
