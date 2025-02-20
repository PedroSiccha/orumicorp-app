function assetPath(path) {
    return window.location.origin + '/' + path;
}

function uploadImg(inputImg) {
    const input = document.getElementById(inputImg);
    const file = input.files[0];

    if (!file) {
        mostrarMensaje("Error", "No se seleccionó ninguna imagen", "error");
        return;
    }

    // Obtener el ID desde la URL
    const urlSegments = window.location.pathname.split('/');
    const userId = urlSegments[urlSegments.length - 1];

    const formData = new FormData();
    formData.append('image', file);
    formData.append('user_id', userId);

    fetch(uploadImgRoute, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { 
                throw new Error(`Error al subir la imagen: ${text}`); 
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Imagen subida:', data);
        
        if (data.success) {
            mostrarMensaje("Correcto", data.message, "success");
        } else {
            mostrarMensaje("Error", data.message, "error");
        }
        const profileImg = document.querySelector("#profileImage"); // Selecciona la imagen
        profileImg.src = assetPath(data.path) + "?" + new Date().getTime(); // Asegura que se recargue
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje("Error", error.message, "error");
    });
}
