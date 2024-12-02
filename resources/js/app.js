/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Bootstrap and other libraries. It is a great starting point
 * when building robust, powerful web applications using Laravel.
 */

import './bootstrap';

// Inicializa Laravel Echo y escucha notificaciones
console.log('Conexión a Pusher:', window.Echo?.connector?.pusher?.connection.state);

window.Echo.channel('notifications')
    .listen('RealTimeNotification', (event) => {
        console.log('Notificación recibida:', event.message);
        alert(`Nueva notificación: ${event.message}`);
    });

console.log('Frontend cargado sin Vue.');
