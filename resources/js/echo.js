import Echo from 'laravel-echo';
import pusher from 'pusher-js';

window.Pusher = pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

const currentUserId = "user-uuid-v4-from-auth";

window.Echo.private(`user.${currentUserId}`)
    .listen('.notification.received', (e) => {
        console.log('🌟 new notification WebSocket:', e.message);
        console.log('notifiacation data:', e.data);

        alert(e.message);
    });
