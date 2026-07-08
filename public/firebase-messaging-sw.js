// Firebase Messaging Service Worker
// Handles background push notifications

importScripts('https://www.gstatic.com/firebasejs/10.12.2/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.12.2/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyBAm1jWjftNszvcu9bKyH75W2dHwRFjE_k",
    authDomain: "pt-pal-procurement.firebaseapp.com",
    projectId: "pt-pal-procurement",
    storageBucket: "pt-pal-procurement.firebasestorage.app",
    messagingSenderId: "335692364830",
    appId: "1:335692364830:web:4ccd081f0a2acc63a3820f"
});

const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage(function (payload) {
    console.log('[firebase-messaging-sw.js] Background message received:', payload);

    const notificationTitle = payload.notification?.title || 'Pesan Baru';
    const notificationOptions = {
        body: payload.notification?.body || 'Anda memiliki pesan baru',
        icon: '/favicon.ico',
        badge: '/favicon.ico',
        tag: 'chat-notification',
        image: payload.notification?.image || null,
        requireInteraction: false,
        data: payload.data || {}
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});

// Handle notification click
self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    const url = event.notification.data?.url || '/dashboard';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (clientList) {
            for (let client of clientList) {
                if (client.url === url && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});
