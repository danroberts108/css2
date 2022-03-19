var myAlert = document.getElementById("duplicateAlert");
myAlert.addEventListener('closed.bs.alert', function () {
    document.getElementById("usernameInput").focus();
}, false);