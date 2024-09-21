function uploadExcelbyFolder(inputExcel, folderId) {
    const fileInput = document.getElementById(inputExcel);
    const folder_id = $(folderId).val();
    console.log(folder_id);

    if (!fileInput || fileInput.files.length === 0) {
        console.error('No se ha seleccionado ningún archivo');
        return;
    }

    const file = fileInput.files[0];
    const formData = new FormData();

    // Agregar archivo al FormData
    formData.append('file', file);

    // Agregar el folder_id al FormData
    formData.append('folder_id', folder_id);

    // Enviar la solicitud con fetch
    fetch('/uploadExcelByFolder', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token // Asegúrate de tener el token CSRF
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
        mostrarMensaje(data.title, data.text, data.status);
        //location.reload();  // Puedes descomentar la alerta si quieres
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
