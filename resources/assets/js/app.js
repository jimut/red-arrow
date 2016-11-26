
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

angular.module('RedArrow', []);
angular.module('RedArrow')
    .controller('DirectionController', require('./controllers/direction.controller'));

window.initMap = function () {
    document.dispatchEvent(new Event('mapinit'));
    window.mapInitialized = true;

    if (document.getElementById('address-input-map') !== null) {
        initAddressInputMaps();
        initAutocomplete();
        tryPreviousLocation();
        tryGeoLocation();
    }

    if (document.getElementById('find-map') !== null) {
        initFindMap();
    }
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

function tryPreviousLocation () {
    let mapLat = document.getElementById('map_lat').value;
    let mapLng = document.getElementById('map_lng').value;

    if (!mapLat || !mapLng)
        return;

    console.log(mapLat + ' ' + mapLng);
    let location = {lat: parseFloat(mapLat), lng: parseFloat(mapLng)};
    changeAddress(location);
}

function tryGeoLocation () {
    if (document.getElementById('map_lat').value || document.getElementById('map_lng').value)
        return;

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

var hospitalLoc;
var hospitalMarker;
var donorMarkers = [];
var donorInfoWindows = [];

function initFindMap () {
    let elm = document.getElementById('find-map');
    let loc = new google.maps.LatLng(22, 78);
    map = new google.maps.Map(elm, {
        zoom: 4,
        center: loc
    });

    $.ajax('/', {
        success: function (data) {
            hospitalLoc = new google.maps.LatLng(data.userInformation.map_lat, data.userInformation.map_lng);
            map.setCenter(hospitalLoc);
            map.setZoom(14);

            hospitalMarker = new google.maps.Marker({
                map: map,
                position: hospitalLoc,
                icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
            });

            findDonors();
        },
        error: function () {
            console.log('Cannot retrieve user information');
        }
    });

    addEventListeners();
}

function addEventListeners () {
    if (!document.getElementById('blood_type') || !document.getElementById('search_radius'))
        return;

    $('#blood_type').change(inputChangeCallback);
    $('#search_radius').change(inputChangeCallback);

    function inputChangeCallback () {
        findDonors();
    }
}

function findDonors () {
    $.ajax('/donor', {
        success: function (donors) {
            filterDonors(donors);
        },
        error: function () {
            console.log('An error occured while fetching donors');
        }
    });

    function filterDonors (donors) {
        let bloodType = $('#blood_type').val();
        let searchRadius = $('#search_radius').val() * 1000;

        donorMarkers.forEach(function (mkr) {
            mkr.setMap(null);
        });

        donorMarkers = [];
        donorInfoWindows = [];

        let bounds = new google.maps.LatLngBounds(null);
        bounds.extend(hospitalLoc);

        for (let i = 0; i < donors.length; i++) {
            let donor = donors[i];

            if (donor.blood_type !== bloodType)
                continue;

            let loc = new google.maps.LatLng(donor.map_lat, donor.map_lng);

            if (google.maps.geometry.spherical.computeDistanceBetween(hospitalLoc, loc) > searchRadius)
                continue;

            let mkr = new google.maps.Marker({
                map: map,
                position: loc
            });

            makeInfoWindow(donor, mkr);

            donorMarkers.push(mkr);

            bounds.extend(loc);
        }

        map.fitBounds(bounds);
        map.panToBounds(bounds);
    }

    function makeInfoWindow (donor, mkr) {
        let contentString = '<div style="max-width: 300px;">' +
                '<h4>' + donor.name + '</h4>' +
                '<p>' +
                '<strong>Date of Birth:</strong> ' + donor.dob + '<br/>' +
                '<strong>Blood Type:</strong> ' + donor.blood_type + '<br/>' +
                '<strong>Contact Number:</strong> ' + donor.contact_no + '<br/>' +
                '<strong>Address:</strong> ' + donor.address +
                '</p>' +
                '<button class="btn btn-primary" style="margin-top: 5px;" onclick="sendNotification(this, ' + donor.id + ')">Send Notification</button>' +
                '</div>';

        let infoWindow = new google.maps.InfoWindow({
            content: contentString
        });

        mkr.addListener('click', function () {
            donorInfoWindows.forEach(function (iw) {
                iw.close();
            });

            infoWindow.open(map, mkr);
        });

        donorInfoWindows.push(infoWindow);
    }
}

window.sendNotification = function (elm, donorId) {
    $(elm).prop('disabled', true);
    $(elm).text('Sending...');

    $.ajax('appointment', {
        method: 'POST',
        data: {
            _token: Laravel.csrfToken,
            donor_id: donorId
        },
        success: function () {
            $(elm).text('Notification Sent');
        },
        error: function () {
            $(elm).text('Failed');
            setTimeout(function () {
                $(elm).text('Send Notification');
                $(elm).prop('disabled', false);
            }, 1000);
        }
    });
};

$(function () {
    if (document.getElementById('address-input-map') !== null) {
        $('#address-input-map').parents('form')[0].onsubmit = function (e) {
            if (!(marker instanceof google.maps.Marker))
                return false;

            let mapLat = $('#map_lat');
            let mapLng = $('#map_lng');

            mapLat.attr('value', marker.getPosition().lat());
            mapLng.attr('value', marker.getPosition().lng());

            return true;
        };
    }
});
