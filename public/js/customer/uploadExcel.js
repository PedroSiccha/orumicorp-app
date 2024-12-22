function uploadExcel(inputExcel, modal, tableName) {

    const fileInput = document.getElementById(inputExcel);

    if (!fileInput || fileInput.files.length === 0) {
        console.error('No se ha seleccionado ningún archivo');
        return;
    }

    const file = fileInput.files[0];
    const formData = new FormData();
    formData.append('file', file);

    fetch('/uploadExcel', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        body: formData
    })
    .then(response => {
        console.log('Ruta:', uploadExcelRoute);
        console.log('Token:', token);
        console.log('Respuesta del servidor:', response);
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Respuesta del servidor:', text);
                throw new Error('Error al subir el formato: ' + text);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Formato Subido:', data);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
        $(tableName).empty();
        $(tableName).html(data.view);
    })
    .catch(error => {
        console.error('Error:', error);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
        $(tableName).empty();
        $(tableName).html(data.view);
    });
}
