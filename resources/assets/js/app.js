
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.initMap = function () {
    initAddressInputMaps();
    initAutocomplete();
    tryGeoLocation();
};

var map;
var marker;

function initAddressInputMaps () {
    let elm = document.getElementById('address-input-map');
    let loc = {lat: 22.5937, lng: 78.9629};
    map = new google.maps.Map(elm, {
        zoom: 4,
        center: loc
    });
}

function initAutocomplete () {
    let input = document.getElementById('pac-input');
    let searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });

    searchBox.addListener('places_changed', function () {
        let places = searchBox.getPlaces();

        if (places.length === 0)
            return;

        let prefPlace = places[0];

        if (!prefPlace.geometry) {
            console.log('Returned place contains no geometry');
            return;
        }

        changeAddress(prefPlace.geometry.location, prefPlace.formatted_address);

        if (prefPlace.geometry.viewport) {
            map.fitBounds(prefPlace.geometry.viewport);
        }
    });
}

function tryGeoLocation () {
    if (!('geolocation' in navigator))
        return;

    navigator.geolocation.getCurrentPosition(function (pos) {
        let location = {lat: pos.coords.latitude, lng: pos.coords.longitude};
        changeAddress(location);
    });
}

function changeAddress (location, formattedAddress) {
    if (marker instanceof google.maps.Marker)
        marker.setMap(null);

    marker = new google.maps.Marker({
        map: map,
        position: location,
        draggable: true
    });
    map.setCenter(location);
    map.setZoom(14);

    let addressInput = document.getElementById('address');
    if (formattedAddress && addressInput.value === '') {
        addressInput.value = formattedAddress;
        return;
    }

    let geocoder = new google.maps.Geocoder();
    geocoder.geocode({location: location}, function (results, status) {
        if (status !== 'OK') {
            window.alert('Geocoder failed due to: ' + status);
            return;
        }

        if (!results[0]) {
            window.alert('No results found');
            return;
        }

        if (addressInput.value === '') {
            addressInput.value = results[0].formatted_address;
        }
    });
}


$(function () {
    $('#address-input-map').parents('form')[0].onsubmit = function (e) {
        if (!(marker instanceof google.maps.Marker))
            return false;

        let mapLat = $('#map_lat');
        let mapLng = $('#map_lng');

        mapLat.value = marker.getPosition().lat();
        mapLng.value = marker.getPosition().lng();

        return true;
    };
});
