function searchStatus(options) {
    var customerStatusId = options.customerStatusId !== undefined ? $(options.customerStatusId).val(): '';
    var tableName = options.tableName !== undefined ? options.tableName: '';
    var limit = $('#limit').val();

    $.post(searchStatusRoute, {customerStatusId: customerStatusId, limit: limit, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
    });
}
