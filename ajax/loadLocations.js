var map = document.getElementById('map');
var locations = [];

function getLocations() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'getMapLocations.php?ajaxToken=' + token);

    xhr.onreadystatechange = function () {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE && xhr.status === OK) {
            let response = xhr.responseText;
            console.log(response);
            let locationArray = JSON.parse(response);
            console.log(locationArray);
        }
    };

    xhr.send(null);
}

document.onload = getLocations();