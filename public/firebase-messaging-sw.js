importScripts("https://www.gstatic.com/firebasejs/7.21.0/firebase-app.js")
importScripts(
    "https://www.gstatic.com/firebasejs/7.21.0/firebase-messaging.js",
)
// For an optimal experience using Cloud Messaging, also add the Firebase SDK for Analytics.
importScripts(
    "https://www.gstatic.com/firebasejs/7.21.0/firebase-analytics.js",
)

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
    apiKey: "AIzaSyDVYD8XZeT7y35-tFXEfdkfHPcybf8Hwnk",
    authDomain: "simkit-5a91e.firebaseapp.com",
    databaseURL: "https://simkit-5a91e.firebaseio.com",
    projectId: "simkit-5a91e",
    storageBucket: "simkit-5a91e.appspot.com",
    messagingSenderId: "460864187987",
    appId: "1:460864187987:web:8f77dc8e1abfe5d06220a6",
    measurementId: "G-YMCWFHG805"
})

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging()

messaging.setBackgroundMessageHandler(function(payload) {
    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    )
})