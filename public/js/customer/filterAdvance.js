function filterOrder(options) {

    var order = options.order !== undefined ? options.order: '';
    var type = options.type !== undefined ? options.type: '';
    var tableName = options.tableName !== undefined ? options.tableName: '';

    $.post(filterOrderRoute, {order: order, type: type, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
    });
}

function filterByAttr(options) {

    var id = options.id !== undefined ? options.id: '';
    var type = options.type !== undefined ? options.type: '';
    var tableName = options.tableName !== undefined ? options.tableName: '';

    $.post(filterByAttrRoute, {id: id, type: type, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
    });
}

function filterByDate(options) {

    var order = options.order !== undefined ? options.order: '';
    var type = options.type !== undefined ? options.type: '';
    var tableName = options.tableName !== undefined ? options.tableName: '';

    $.post(filterByDateRoute, {order: order, type: type, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
    });
}
