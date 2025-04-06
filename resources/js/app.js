import 'select2';
import toastr from 'toastr';
import { initNotifyShooterPolling } from './features/getNotify.js';

// toastr.success('Bienvenido');
// console.log('Frontend cargado sin Vue.');
window.toastr = toastr;

if (typeof notiffyShooterRoute !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        initNotifyShooterPolling();
    });
}
