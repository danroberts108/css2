let alert = document.getElementById('duplicateAlert');
let username = document.getElementById('usernameInput');

function removeDupAlert() {
    alert.remove();
    username.classList.remove('border-danger');
    console.log("removed class");
}

document.getElementById('usernameInput').addEventListener('focusout', removeDupAlert, false);