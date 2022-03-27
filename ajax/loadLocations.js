var locations;

function getLocations(callback) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'getMapLocations.php?ajaxToken=' + token);

    xhr.onreadystatechange = function () {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE && xhr.status === OK) {
            let response = xhr.responseText;
            let locationArray = JSON.parse(response);
            console.log(locationArray);
            for (i = 0; i < locationArray.length; i++) {
                locations = locationArray;
            }
        }
    };

    xhr.send(null);

    callback();
}

document.onload = getLocations(genMap);
