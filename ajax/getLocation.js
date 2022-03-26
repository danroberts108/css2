var userLon, userLat = 0;

function checkGeolocation() {
    return "geolocation" in navigator;
}

function updateUserLocation(lon, lat) {
    let userid = document.getElementById('userid').getAttribute('userid');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "updateUserLocation.php?lat=" + lat + '&lon=' + lon + '&userid=' + userid + '&ajaxToken=' + token);

    xhr.send(null);

}

function findLocation(successCallback) {
    function success(position) {
        userLon = position.coords.longitude;
        userLat = position.coords.latitude;
        successCallback(userLon, userLat);
    }

    function error() {
        console.log('Error getting location.');
    }

    navigator.geolocation.getCurrentPosition(success, error);
}


function runUpdate() {
    if (checkGeolocation()) {
        findLocation(updateUserLocation);
    }
}

document.onload = runUpdate();