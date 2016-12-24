var config = {
    apiKey: "AIzaSyCqb1VLqDntcglZKPU4KYyDQOutAke_TGU",
    authDomain: "red-arrow-152817.firebaseapp.com",
    databaseURL: "https://red-arrow-152817.firebaseio.com",
    storageBucket: "red-arrow-152817.appspot.com",
    messagingSenderId: "106549887679"
};
firebase.initializeApp(config);

const messaging = firebase.messaging();

messaging.requestPermission()
.then(function () {
    return messaging.getToken();
}).then(function (token) {
    window.fcmToken = token;
}).catch(function (err) {
    console.log('Error Occured: ', err);
});

messaging.onMessage(function (payload) {
    console.log('onMessage: ', payload);
});
