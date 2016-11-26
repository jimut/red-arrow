function controller () {
    let map;

    function init () {
        if (document.getElementById('direction-map') === null)
            return;

        let elm = document.getElementById('direction-map');
        let loc = {lat: 22.5937, lng: 78.9629};
        map = new google.maps.Map(elm, {
            center: loc,
            zoom: 4
        });
    }

    if (window.mapInitialized) {
        init();
    } else {
        document.addEventListener('mapinit', init);
    }

}

controller.$inject = [];

module.exports = controller;
