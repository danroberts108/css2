var canUpdateLocation = true;

function checkGeolocation() {
    return "geolocation" in navigator;
}

function getUserLocation() {
    if (checkGeolocation()) {
        return navigator.geolocation.getCurrentPosition(success, error);
    } else {
        canUpdateLocation = false;
        return false;
    }
}

function success() {
    canUpdateLocation = true;
}

function error() {
    canUpdateLocation = false;
}

function updateUserLocation(position) {
    let lat = position.coords.latitude;
    let lon = position.coords.longitude;
    let userid = document.getElementById('userid').value;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "updateUserLocation.php?lat=" + lat + '&lon=' + lon + '&userid=' + userid + '&ajaxToken=' + token);

    xhr.send(null);

}

function runUpdate() {
    if (canUpdateLocation) {
        let location = getUserLocation();
        if (!location) {
            return;
        }
        updateUserLocation(location);
    }
}

window.onload = runUpdate();