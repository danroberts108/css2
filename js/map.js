let locations = [];
let features = [];
let locationObjectArray = [];

function genMap() {

    for (let i = 0; i < Object.keys(locations).length; i++) {
        let point = new ol.geom.Point(ol.proj.fromLonLat(locations[i]));
        let feature = new ol.Feature({
            geometry: point
        })
        feature.set('userid', locationObjectArray[i]._userid);
        features.push(feature);
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
            let featureArray = map.getFeaturesAtPixel(event.pixel);
            console.log(featureArray);

            let featureLonLat = ol.proj.transform(featureArray[0].getGeometry().getCoordinates(), 'EPSG:3857', 'EPSG:4326');
            console.log(featureLonLat);

            let user = locationObjectArray.filter(item => item._userid === featureArray[0].get('userid'));
            console.log(user[0]);

            let coordinate = event.coordinate;
            let infoTitle = document.createElement('h5');
            infoTitle.classList.add('popover-title');
            infoTitle.innerText = user[0]._username;

            let infoLink = document.createElement('a');
            infoLink.classList.add('popover-link', 'btn', 'btn-primary');
            infoLink.setAttribute('href', 'user.php?userid=' + user[0]._userid);
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

function getUserFromLonLat(lon, lat) {
    return locationObjectArray.filter(obj => (obj.lon === lon && obj.lat === lat));
}

document.onload = getLocations(genMap);