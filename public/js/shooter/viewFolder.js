function viewFolder(params) {
 var categoryId = params.categoryId !== undefined ? params.categoryId: '';
 var tableName = params.tableName !== undefined ? params.tableName : '';
 $.post(viewFolderRoute, {categoryId: categoryId, _token: token}).done(function (data) {
    $(tableName).empty();
    $(tableName).html(data.view);
 });
}
