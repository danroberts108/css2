let usernameInput = document.getElementById('usernameInput');
let regButton = document.getElementById('regButton');

let tooltip;

//Function to check if the username exists on the register page before the user can create that account
function checkDuplicateUsername() {

    let uname = usernameInput.value;

    //Creates the ajax connection
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'checkDuplicateUsername.php?uname=' + uname, true);

    xhr.onreadystatechange = function() {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE) {
            if (xhr.status === OK) {
                //Checks if the username was in fact duplicated or not
                if (xhr.responseText === 'true') {
                    //Adds the tooltip next to the username box telling the user it is already registered
                    tooltip = new bootstrap.Tooltip(usernameInput, {boundary: document.body, trigger: 'manual'});
                    //Shows the tooltip on the page
                    tooltip.show();
                    //Disables the register button so the user cannot submit the form with the duplicate username
                    regButton.setAttribute('disabled', '');
                    //Sets the username input border to red
                    usernameInput.classList.add('border-danger');
                } else {
                    //Enables the submit button again if it is not duplicated
                    if (regButton.hasAttribute('disabled')) {
                        regButton.removeAttribute('disabled');
                    }
                    //Removes the red border over the username input if it is not duplicated
                    if (usernameInput.classList.contains('border-danger')) {
                        usernameInput.classList.remove('border-danger');
                    }
                    //Hides the tooltip if the username is not duplicated
                    if (usernameInput.hasAttribute('aria-describedby')) {
                        tooltip.hide();
                    }
                }
            } else {
                //Logs the ajax error to the console
                console.log('Error: ' + xhr.status);
            }
        }
    };

    //Sends the ajax request
    xhr.send(null);

}

//Adds the event listener to the input box
usernameInput.addEventListener('keyup', checkDuplicateUsername, false);