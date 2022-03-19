

let usernameInput = document.getElementById('usernameInput');
let regButton = document.getElementById('regButton');

let tooltip;

function checkDuplicateUsername() {

    let uname = usernameInput.value;

    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'checkDuplicateUsername.php?uname=' + uname, true);

    xhr.onreadystatechange = function() {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE) {
            if (xhr.status === OK) {
                if (xhr.responseText === 'true') {
                    tooltip = new bootstrap.Tooltip(usernameInput, {boundary: document.body, trigger: 'manual'});
                    tooltip.show();
                    regButton.setAttribute('disabled', '');
                    usernameInput.classList.add('border-danger');
                } else {
                    if (regButton.hasAttribute('disabled')) {
                        regButton.removeAttribute('disabled');
                    }
                    if (usernameInput.classList.contains('border-danger')) {
                        usernameInput.classList.remove('border-danger');
                    }
                    if (usernameInput.hasAttribute('aria-describedby')) {
                        tooltip.hide();
                    }
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };

    xhr.send(null);

}

usernameInput.addEventListener('keyup', checkDuplicateUsername, false);