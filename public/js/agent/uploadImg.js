function uploadImg(inputImg) {

    const input = document.getElementById(inputImg);
    const file = input.files[0];
    const formData = new FormData();
    formData.append('image', file);

    fetch(uploadImgRoute, {method: 'POST', headers: {
        'X-CSRF-TOKEN': token
    }, body: formData})
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al subir la imagen');
        }
        location.reload();
        return response.json();
    })
    .then(data => {
        console.log('Imagen subida:', data);
        location.reload();
        //alert('Imagen subida correctamente');
    })
    .catch(error => {
        console.error('Error:', error);
        location.reload();
        //alert('Error al subir la imagen');
    });

}
