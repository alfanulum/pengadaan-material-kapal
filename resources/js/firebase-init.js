// Firebase Initialization & FCM Token Registration
// This file handles requesting notification permission and saving the FCM token to the server.

import { initializeApp } from 'firebase/app';
import { getMessaging, getToken, onMessage } from 'firebase/messaging';

const firebaseConfig = {
    apiKey: "AIzaSyBAm1jWjftNszvcu9bKyH75W2dHwRFjE_k",
    authDomain: "pt-pal-procurement.firebaseapp.com",
    projectId: "pt-pal-procurement",
    storageBucket: "pt-pal-procurement.firebasestorage.app",
    messagingSenderId: "335692364830",
    appId: "1:335692364830:web:4ccd081f0a2acc63a3820f"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

/**
 * Request notification permission and get FCM token.
 * The token is sent to the Laravel backend for storage.
 */
async function initFirebaseNotifications() {
    try {
        // Request permission
        const permission = await Notification.requestPermission();

        if (permission !== 'granted') {
            console.warn('[FCM] Notification permission denied.');
            return;
        }

        // Register service worker and wait for it to be ready
        const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
        await navigator.serviceWorker.ready;

        // Get FCM token (VAPID key from Firebase Console → Project Settings → Cloud Messaging)
        const token = await getToken(messaging, {
            serviceWorkerRegistration: registration,
            // If you have a VAPID key, add it here:
            // vapidKey: 'YOUR_VAPID_KEY_HERE'
        });

        if (!token) {
            console.warn('[FCM] No FCM token received.');
            return;
        }

        console.log('[FCM] Token:', token);

        // Save token to server
        await saveFcmToken(token);

        // Handle foreground messages (when user is on the page)
        onMessage(messaging, (payload) => {
            console.log('[FCM] Foreground message:', payload);
            showToastNotification(
                payload.notification?.title || 'Pesan Baru',
                payload.notification?.body || 'Anda memiliki pesan baru'
            );
        });

    } catch (error) {
        console.error('[FCM] Error initializing notifications:', error);
    }
}

/**
 * Save FCM token to Laravel backend via AJAX.
 */
async function saveFcmToken(token) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!csrfToken) {
        console.warn('[FCM] CSRF token not found. Cannot save FCM token.');
        return;
    }

    try {
        const response = await fetch('/fcm-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ token }),
        });

        if (response.ok) {
            console.log('[FCM] Token saved to server successfully.');
        } else {
            console.warn('[FCM] Failed to save token:', response.statusText);
        }
    } catch (err) {
        console.error('[FCM] Error saving token:', err);
    }
}

/**
 * Show a premium toast notification in the UI.
 * @param {string} title
 * @param {string} body
 */
export function showToastNotification(title, body, type = 'info') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const colorMap = {
        info:    { bg: 'from-blue-900 to-blue-700',   icon: '💬', border: 'border-blue-500' },
        success: { bg: 'from-green-900 to-green-700', icon: '✅', border: 'border-green-500' },
        warning: { bg: 'from-amber-900 to-amber-700', icon: '⚠️', border: 'border-amber-500' },
        error:   { bg: 'from-red-900 to-red-700',     icon: '❌', border: 'border-red-500' },
    };

    const color = colorMap[type] || colorMap.info;
    const id = 'toast-' + Date.now();

    const toast = document.createElement('div');
    toast.id = id;
    toast.className = `
        flex items-start gap-3 p-4 rounded-2xl shadow-2xl border
        bg-gradient-to-br ${color.bg} ${color.border}
        text-white max-w-sm w-full
        transform translate-x-full opacity-0
        transition-all duration-500 ease-out
    `.trim().replace(/\s+/g, ' ');

    toast.innerHTML = `
        <div class="text-2xl mt-0.5 flex-shrink-0">${color.icon}</div>
        <div class="flex-1 min-w-0">
            <p class="font-bold text-sm truncate">${title}</p>
            <p class="text-xs text-white/80 mt-0.5 line-clamp-2">${body}</p>
        </div>
        <button onclick="document.getElementById('${id}').remove()"
            class="text-white/60 hover:text-white transition text-lg leading-none flex-shrink-0 mt-0.5">
            ×
        </button>
    `;

    container.appendChild(toast);

    // Animate in
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
        });
    });

    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.classList.remove('translate-x-0', 'opacity-100');
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => toast.remove(), 500);
    }, 5000);
}

// Start Firebase on page load (only if user is logged in)
if (document.querySelector('meta[name="csrf-token"]')) {
    initFirebaseNotifications();
}

// Expose to window so Blade scripts can call it without ES module imports
window.showToastNotification = showToastNotification;

export { messaging };
