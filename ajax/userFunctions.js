let requestBtn = document?.getElementById('requestBtn');
let cancelBtn = document?.getElementById('cancelBtn');
let removeBtn = document?.getElementById('removeBtn');
let blockBtn = document?.getElementById('blockBtn');

let actionDiv = document.getElementById('actionDiv');

let userid = document.getElementById('thisuserid').value;

function requestFriend() {
    ajaxRequst(userid, 'request');
}

function removeFriend() {
    ajaxRequst(userid, 'remove');
}

function blockUser() {
    ajaxRequst(userid, 'block');
}

function cancelRequest() {
    ajaxRequst(userid, 'cancel');
}

function ajaxRequst(userid, requestType) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', "userFunctions.php?userid=" + userid + "&type=" + requestType + '&ajaxToken=' + token);

    xhr.onreadystatechange = function () {
        let OK = 200;
        let DONE = 4;
        if (xhr.status === OK && xhr.readyState === DONE) {
            getActions();
        }
    };
}

function ajaxIsFriend() {
    let isFriend;

    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'isFriend.php?userid=' + userid + '&ajaxToken=' + token);

    xhr.onreadystatechange = function() {
        let OK = 200;
        let DONE = 4;
        if (xhr.status === OK && xhr.readyState === DONE) {
            return xhr.responseText === "true";
        }
    };
}

function getActions(callback) {
    let isFriend = ajaxIsFriend();

    let container = document.createElement('div');

    if (actionDiv.hasChildNodes()) {
        actionDiv.firstChild.remove();
    }

    if (isFriend) {
        let removeBtn = document.createElement('button');
        removeBtn.classList.add("btn", "btn-block", "btn-danger");
        removeBtn.id = 'removeBtn';
        container.append(removeBtn);
    } else {
        let requestBtn = document.createElement('button');
        requestBtn.classList.add('btn', 'btn-block', 'btn-primary');
        requestBtn.id = 'requestBtn';
        container.append(requestBtn);
    }

    let blockBtn = document.createElement('button');
    blockBtn.classList.add('btn', 'btn-block', 'btn-danger');
    blockBtn.id = 'blockBtn';

    container.append(blockBtn);

    actionDiv.append(container);

    callback();
}

function addListeners() {
    requestBtn?.addEventListener('click', requestFriend, false);
    removeBtn?.addEventListener('click', removeFriend, false);
    blockBtn?.addEventListener('click', blockUser, false);
    cancelBtn?.addEventListener('click', cancelRequest, false);
}

window.onload = getActions(addListeners);

