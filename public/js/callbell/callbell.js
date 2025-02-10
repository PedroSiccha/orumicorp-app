function filterChannelCallbell(options) {
    var channel = options.selectChannel !== undefined ? $(options.selectChannel).val(): '';
    var tableName = options.tableName !== undefined ? options.tableName: '';

    $.post(filterChannelRoute, { channel: channel, _token: token })
        .done(function(data) {
            $(tableName).empty();
            $(tableName).html(data.view);
        });
}
