function getPrivateIPAddress() {
    // Realizar una solicitud HTTP a un servicio externo que devuelva la dirección IP del cliente
    fetch('https://api64.ipify.org?format=json')
        .then(response => response.json())
        .then(data => {
            // Obtener la dirección IP del cliente del objeto de respuesta
            var ipAddress = data.ip;
            console.log('Dirección IP privada del cliente:', ipAddress);
        })
        .catch(error => {
            console.error('Error al obtener la dirección IP privada:', error);
        });
}
getPrivateIPAddress();
