let locations = [];
let features = [];
let locationObjectArray = [];

function genMap() {

    for (let i = 0; i < Object.keys(locations).length; i++) {
        features.push(new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat(locations[i]))
        }));
    }

// create the source and layer for random features
    const vectorSource = new ol.source.Vector({
        features
    });

    const markerLayer = new ol.layer.Vector({
        source: vectorSource
    });


    const map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            }),
            markerLayer
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([37.41, 8.82]),
            zoom: 0
        })
    });

    let container = document.getElementById('popup');
    let content = document.getElementById('popup-content');
    let closer = document.getElementById('popup-closer');

    let overlay = new ol.Overlay({
        element: container,
        autoPan: true,
        autPanAnimation: {
            duration: 250
        }
    });

    map.addOverlay(overlay);

    function closePopup() {
        overlay.setPosition(undefined);
        closer.blur();
        return false;
    }

    closer.addEventListener('click', closePopup, false);

    function openPopup(event) {
        if (map.hasFeatureAtPixel(event.pixel) === true) {
            let coordinate = event.coordinate;
            let infoTitle = document.createElement('h5');
            infoTitle.classList.add('popover-title');
            infoTitle.innerText = 'Username';

            let infoLink = document.createElement('a');
            infoLink.classList.add('popover-link', 'btn', 'btn-primary');
            infoLink.innerText = 'View Profile'

            let infoDiv = document.createElement('div');
            infoDiv.classList.add('popover');

            let containerDiv = document.createElement('div');
            containerDiv.classList.add('container');

            infoDiv.appendChild(infoTitle);
            infoDiv.appendChild(infoLink);
            containerDiv.appendChild(infoDiv);

            content.appendChild(containerDiv);
            overlay.setPosition(coordinate);
        } else {
            overlay.setPosition(undefined);
            closer.blur();
        }
    }

    map.addEventListener('click', openPopup, false);

}

function getLocations(callback) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'getMapLocations.php?ajaxToken=' + token);

    xhr.onreadystatechange = getLocations;

    function getLocations() {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE && xhr.status === OK) {
            let response = xhr.responseText;
            locationObjectArray = JSON.parse(response);
            for (i = 0; i < locationObjectArray.length; i++) {
                locations.push([locationObjectArray[i]._lon, locationObjectArray[i]._lat]);
            }
            console.log(locations);
            callback();
        }
    }

    xhr.send(null);
}

document.onload = getLocations(genMap);