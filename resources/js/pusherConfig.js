import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

window.Echo.channel('notifications')
    .listen('NotificationEvent', (e) => {
        const notificationList = document.getElementById('notification-list');
        const newNotification = document.createElement('li');
        newNotification.textContent = e.notification.message;
        notificationList.prepend(newNotification);  // Ajouter la notification en haut de la liste

        const notificationCount = document.getElementById('notification-count');
        let count = parseInt(notificationCount.textContent) || 0;
        count += 1;
        notificationCount.textContent = count;
        notificationCount.style.display = 'inline';
    });

document.getElementById('notification-icon').addEventListener('click', () => {
    const notificationList = document.getElementById('notification-list');
    if (notificationList.style.display === 'none') {
        notificationList.style.display = 'block';
    } else {
        notificationList.style.display = 'none';
    }
});
