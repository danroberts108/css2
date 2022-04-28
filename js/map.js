let locations = [];
let features = [];
let locationObjectArray = [];
let map;

//Function to create the map layer and then add the markers once the map has been created
function genMap() {

    //Defines the new map
    map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([37.41, 8.82]),
            zoom: 0,
            maxZoom: 5
        })
    });

    //Adds the marker layer
    addMarkerLayer();
}

//Returns a new marker point
function newMarker(lonLatArray) {
    return new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat(lonLatArray))
    });
}


//Function to add the marker layer
function addMarkerLayer() {
    //Creates all the markers on the layer with the lon & lat from each of the locations provided
    for (let i = 0; i < Object.keys(locations).length; i++) {
        //Creates the new point
        let feature = newMarker(locations[i]);
        //Sets the userid attribute on each of the features to identify it
        feature.set('userid', locationObjectArray[i]._userid);
        //Adds the feature to the feature array
        features.push(feature);
    }

    //Creates the vector source
    const vectorSource = new ol.source.Vector({
        features
    });

    //Creates the layer
    const markerLayer = new ol.layer.Vector({
        source: vectorSource
    });

    //Adds the layer to the map
    map.addLayer(markerLayer);

    let container = document.getElementById('popup');
    let content = document.getElementById('popup-content');
    let closer = document.getElementById('popup-closer');

    //Creates the overlay for the popovers
    let overlay = new ol.Overlay({
        element: container,
        autoPan: true,
        autPanAnimation: {
            duration: 250
        }
    });

    //Adds the overlay to the map
    map.addOverlay(overlay);

    //Function to close the popover when unfocused
    function closePopup() {
        overlay.setPosition(undefined);
        closer.blur();
        return false;
    }

    //Adds the event listener to the closer element
    closer.addEventListener('click', closePopup, false);

    //Function to create and display the popover for each point
    function openPopup(event) {
        overlay.setPosition(undefined);
        closer.blur();
        if (map.hasFeatureAtPixel(event.pixel) === true) {
            //Creates the array of features from where the user has clicked
            let featureArray = map.getFeaturesAtPixel(event.pixel);

            //Gets an array of the user(s) that are in that feature by the userid attribute on it
            let user = locationObjectArray.filter(item => item._userid === featureArray[0].get('userid'));

            //Gets the coordinate of where the click happened
            let coordinate = event.coordinate;

            //Creates the info title element and sets its properties
            let infoTitle = document.createElement('h5');
            infoTitle.classList.add('popover-title');
            infoTitle.innerText = user[0]._username;

            //Creates the link to the user page button and sets its properties
            let infoLink = document.createElement('a');
            infoLink.classList.add('popover-link', 'btn', 'btn-primary');
            infoLink.setAttribute('href', 'user.php?userid=' + user[0]._userid);
            infoLink.innerText = 'View Profile'

            //Creates the containing div for the popover and sets its properties
            let infoDiv = document.createElement('div');
            infoDiv.classList.add('popover');

            //Adds the title and link to the containing div
            infoDiv.appendChild(infoTitle);
            infoDiv.appendChild(infoLink);

            //Adds the popover to the map and sets it to where the click event occurred
            content.appendChild(infoDiv);
            overlay.setPosition(coordinate);
        } else {
            //Removes the popover from the map if focus is lost from it
            overlay.setPosition(undefined);
            closer.blur();
        }
    }

    //Adds the event listener to the map element
    map.addEventListener('click', openPopup, false);
}

//Function to get the locations of the users friends
function getLocations(callback) {
    //Creates the ajax connection
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'getMapLocations.php?ajaxToken=' + token);

    xhr.onreadystatechange = getLocations;

    function getLocations() {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE && xhr.status === OK) {
            let response = xhr.responseText;
            locationObjectArray = JSON.parse(response);
            //Adds the plain lon and lat to a locations array for the layer creator to parse into features
            for (i = 0; i < locationObjectArray.length; i++) {
                locations.push([locationObjectArray[i]._lon, locationObjectArray[i]._lat]);
            }
            //Runs the function specified in the argument of the parent function as a callback, so it only runs after all locations have been fetched
            callback();
        }
    }

    //Sends the ajax request
    xhr.send(null);
}

//Runs the function getLocations with the callback of genMap on the document load
document.onload = getLocations(genMap);