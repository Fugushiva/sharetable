document.addEventListener('DOMContentLoaded', () => {
    const notificationIcon = document.getElementById('notification-icon');
    const notificationList = document.getElementById('notification-list');
    const notificationCount = document.getElementById('notification-count');

    if (notificationIcon) {
        // Charger les notifications non lues au chargement de la page
        fetch('/api/notifications/unread', {
            headers: {
                'Accept': 'application/json'
            },
            credentials: 'include'  // Inclure les cookies de session
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Utiliser json() pour convertir la réponse en JSON
            })
            .then(notifications => {
                console.log('Notifications:', notifications); // Message de débogage
                let count = notifications.length;
                notificationCount.textContent = count;
                notificationCount.classList.toggle('hidden', count === 0);

                notifications.forEach((notification, index) => {
                    console.log('Notification data:', notification.data); // Afficher les données de notification

                    // Parsing JSON string
                    const notificationData = JSON.parse(notification.data);
                    const message = notificationData.message ? notificationData.message : 'Notification sans message';
                    const url = notificationData.url ? notificationData.url : '#'; // Assurez-vous que l'URL est incluse
                    const newNotification = document.createElement('li');
                    newNotification.className = 'p-4 cursor-pointer unread hover:bg-gray-100 flex items-center'; // Modifier la classe pour les notifications non lues
                    console.log('Adding notification:', newNotification); // Message de débogage

                    // Ajouter la boule rouge
                    const badge = document.createElement('span');
                    badge.className = 'notification-badge';
                    newNotification.appendChild(badge);

                    // Ajouter le message de notification avec un lien
                    const messageLink = document.createElement('a');
                    messageLink.href = url; // Utiliser l'URL de la notification
                    messageLink.textContent = message;
                    newNotification.appendChild(messageLink);

                    newNotification.addEventListener('click', () => {
                        // Marquer la notification comme lue
                        fetch('/api/notifications/read', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            credentials: 'include'
                        }).then(() => {
                            newNotification.classList.remove('unread');
                            let currentCount = parseInt(notificationCount.textContent);
                            notificationCount.textContent = currentCount > 0 ? currentCount - 1 : 0;
                            notificationCount.classList.toggle('hidden', currentCount - 1 === 0);
                            badge.remove(); // Retirer la boule rouge après avoir marqué comme lu
                        }).catch(error => console.error('Error marking notification as read:', error));
                    });

                    notificationList.prepend(newNotification);

                    // Ajouter la ligne de séparation rouge sauf après la dernière notification
                    if (index < notifications.length - 1) {
                        const separator = document.createElement('div');
                        separator.className = 'flex justify-center';
                        separator.innerHTML = '<hr class="border-t border-red-750 w-3/4 my-2">';
                        notificationList.prepend(separator);
                    }
                });
            })
            .catch(error => console.error('Error fetching unread notifications:', error));

        // Toggle visibility of the notification list on icon click
        notificationIcon.addEventListener('click', () => {
            notificationList.classList.toggle('hidden');
        });
    } else {
        console.error('Notification icon not found');
    }
});
