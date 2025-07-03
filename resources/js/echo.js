import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT || 80,
    wssPort: import.meta.env.VITE_REVERB_PORT || 443,
    forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Recupera l'userId dal meta tag
const userIdMeta = document.querySelector('meta[name="user-id"]');
const userId = userIdMeta ? userIdMeta.getAttribute('content') : null;

if (userId) {
    window.Echo.private('chat.' + userId)
        .listen('.message.sent', (e) => {
            window.Livewire.dispatch('new-message-sent', {
                data: {
                    sender_id: e.sender.id,
                    receiver_id: e.receiver_id,
                    message_id: e.id
                }
            });
        }) 
}