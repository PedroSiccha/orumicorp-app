function filterChannelCallbell(options) {
    var channel = options.selectChannel !== undefined ? $(options.selectChannel).val(): '';
    var tableName = options.tableName !== undefined ? options.tableName: '';

    $.post(filterChannelRoute, { channel: channel, _token: token })
        .done(function(data) {
            $(tableName).empty();
            $(tableName).html(data.view);
        });
}

function filterStatusCallbell(options) {
    var status = options.selectStatus !== undefined ? $(options.selectStatus).val(): '';
    var tableName = options.tableName !== undefined ? options.tableName: '';
    $.post(filterStatusRoute, { status: status, _token: token })
        .done(function(data) {
            $(tableName).empty();
            $(tableName).html(data.view);
        });
}
 