function validateFile(input) {
    var file = input.files[0]; // Obtener el archivo seleccionado
    var fileLabel = document.getElementById("fileLabel"); // Botón de selección
    var uploadButton = document.getElementById("uploadButton"); // Botón de subida
    var errorMessage = document.getElementById("errorMessage");
    var fileName = document.getElementById("fileName");

    if (!fileLabel || !uploadButton) {
        console.error("Los botones no se encontraron en el DOM.");
        return;
    }

    if (file) {
        var allowedTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"]; // Tipos permitidos
        var maxSize = 2 * 1024 * 1024; // 2MB en bytes

        // Mostrar el nombre del archivo correctamente
        // fileName.textContent = file.name;

        if (!allowedTypes.includes(file.type) || file.size > maxSize) {
            fileLabel.classList.remove("btn-primary", "btn-success");
            fileLabel.classList.add("btn-danger"); // Cambia el botón de selección a rojo

            uploadButton.classList.remove("btn-primary", "btn-success");
            uploadButton.classList.add("btn-danger"); // Cambia el botón de subida a rojo

            if (errorMessage) errorMessage.style.display = "block"; // Muestra el mensaje de error
        } else {
            fileLabel.classList.remove("btn-danger");
            fileLabel.classList.add("btn-primary"); // Cambia el botón de selección a verde

            uploadButton.classList.remove("btn-danger");
            uploadButton.classList.add("btn-primary"); // Cambia el botón de subida a verde

            if (errorMessage) errorMessage.style.display = "none"; // Oculta el mensaje de error
        }
    }
}

function getUserIdFromUrl() {
    var pathArray = window.location.pathname.split('/');
    return pathArray[pathArray.length - 1]; // Obtiene el último segmento de la URL
}
