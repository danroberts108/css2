let userLon, userLat = 0;

//Function to check if geolocation exists/is enabled/is allowed in the users browser
function checkGeolocation() {
    return "geolocation" in navigator;
}

//Ajax function to update the users location in the database
function updateUserLocation(lon, lat) {
    let userid = document.getElementById('userid').getAttribute('userid');

    //Creates the ajax request
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "updateUserLocation.php?lat=" + lat + '&lon=' + lon + '&userid=' + userid + '&ajaxToken=' + token);

    //Sends the request
    xhr.send(null);

}

//Function to get the location of the user and set the variables to this
function findLocation(successCallback) {
    //Function to run on success of getting the users location from the browser
    function success(position) {
        //Sets the variables to the users location if it exists with the ?. function
        userLon = position.coords?.longitude;
        userLat = position.coords?.latitude;
        //Calls the callback function once the location has been set
        successCallback(userLon, userLat);
    }

    //Function to run on failure to get the users location from the browser
    function error() {
        console.log('Error getting location.');
    }

    //Runs the location finding function in the browser
    navigator.geolocation.getCurrentPosition(success, error);
}


//Function to only run the geolocation function if it is enabled in the browser
function runUpdate() {
    if (checkGeolocation()) {
        findLocation(updateUserLocation);
    }
}

//Runs the runUpdate function when the document loads
document.onload = runUpdate();