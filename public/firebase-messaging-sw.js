importScripts('https://www.gstatic.com/firebasejs/3.6.4/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.6.4/firebase-messaging.js');

var config = {
    apiKey: "AIzaSyCqb1VLqDntcglZKPU4KYyDQOutAke_TGU",
    authDomain: "red-arrow-152817.firebaseapp.com",
    databaseURL: "https://red-arrow-152817.firebaseio.com",
    storageBucket: "red-arrow-152817.appspot.com",
    messagingSenderId: "106549887679"
};
firebase.initializeApp(config);

const messaging = firebase.messaging();