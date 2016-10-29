
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.initMap = function() {
    initAddressInputMaps();
};

function initAddressInputMaps() {
    let elms = $('.address-input-map');
    let loc = {lat: 22.5937, lng: 78.9629};
    for (let i = 0; i < elms.length; i++) {
        let elm = elms[i];
        let map = new google.maps.Map(elm, {
            zoom: 4,
            center: loc
        });
        // let marker = new google.maps.Marker({
        //     position: uluru,
        //     map: map,
        //     draggable: true
        // });
    }
}
