function uploadExcel(inputExcel) {
    const fileInput = $(inputExcel)[0];

    const input = document.getElementById(inputExcel);
    const file = fileInput.files[0];
    const formData = new FormData();
    formData.append('file', file);

    fetch(uploadExcelRoute, {method: 'POST', headers: {
        'X-CSRF-TOKEN': token
    }, body: formData})
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al subir el formato');
        }
        location.reload();
        return response.json();
    })
    .then(data => {
        console.log('Formato Subido:', data);
        //location.reload();
        //alert('Imagen subida correctamente');
    })
    .catch(error => {
        console.error('Error:', error);
        //location.reload();
        //alert('Error al subir la imagen');
    });

}
