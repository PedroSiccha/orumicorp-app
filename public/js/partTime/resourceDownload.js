function updateDownloadLinks() {
    const area = $('#area').val();
    const code = $('#inputCode').val();
    const dateStart = $('#date_added_init').val();
    const dateEnd = $('#date_added_end').val();

    const query = $.param({
        area: area,
        code: code,
        date_start: dateStart,
        date_end: dateEnd
    });

    $('#excelDownload').attr('href', `/descargar-asistencia-excel?${query}`);
    $('#pdfDownload').attr('href', `/descargar-asistencia-pdf?${query}`);
}

// Llama a esta función cuando cambien los filtros
$('#area, #inputCode, #date_added_init, #date_added_end').on('change keyup', updateDownloadLinks);
updateDownloadLinks(); // Inicial al cargar

