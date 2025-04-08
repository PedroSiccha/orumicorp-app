import 'select2';
import toastr from 'toastr';
import { initNotifyShooterPolling } from './features/getNotify.js';
import * as bootstrap from 'bootstrap'
window.bootstrap = bootstrap;

window.toastr = toastr;

const tokenMeta = document.querySelector('meta[name="csrf-token"]');
if (tokenMeta) {
    window.token = tokenMeta.getAttribute('content');
}

if (typeof notiffyShooterRoute !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        initNotifyShooterPolling();
    });
}
