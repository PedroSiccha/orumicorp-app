import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

console.log(process.env.MIX_PUSHER_APP_KEY);
console.log(process.env.MIX_PUSHER_APP_CLUSTER);

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY, // Cambiado a MIX_
    cluster: process.env.MIX_PUSHER_APP_CLUSTER, // Cambiado a MIX_
    wsHost: process.env.MIX_PUSHER_HOST || `ws-${process.env.MIX_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: process.env.MIX_PUSHER_PORT || 80,
    wssPort: process.env.MIX_PUSHER_PORT || 443,
    forceTLS: (process.env.MIX_PUSHER_SCHEME || 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

