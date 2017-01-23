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
    window.Laravel.fcmToken = token;
    attachFCMTokenToLoginForm();
    attachFCMTokenToSocialLoginLinks();
}).catch(function (err) {
    console.log('Error Occured: ', err);
});

messaging.onMessage(function (payload) {
    console.log('onMessage: ', payload);
});

function attachFCMTokenToLoginForm () {
    if (window.location.pathname.startsWith('/login') && window.Laravel.fcmToken && document.querySelector('form')) {
        let form = document.querySelector('form');
        let input = document.createElement('input');
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', 'fcm_token');
        input.setAttribute('value', window.Laravel.fcmToken);
        form.appendChild(input);
        document.querySelector('form button[type="submit"]').removeAttribute('disabled');
    }
}

function attachFCMTokenToSocialLoginLinks () {
    if ((window.location.pathname.startsWith('/login') || window.location.pathname.startsWith('/register')) && window.Laravel.fcmToken) {
        let facebookLoginLink = document.getElementById('facebook-login-link');
        let googleLoginLink = document.getElementById('google-login-link');

        if (facebookLoginLink) {
            let href = facebookLoginLink.getAttribute('href') + '?fcm_token=' + window.Laravel.fcmToken;
            facebookLoginLink.setAttribute('href', href);
            facebookLoginLink.removeAttribute('disabled');
        }

        if (googleLoginLink) {
            let href = googleLoginLink.getAttribute('href') + '?fcm_token=' + window.Laravel.fcmToken;
            googleLoginLink.setAttribute('href', href);
            googleLoginLink.removeAttribute('disabled');
        }
    }
}
