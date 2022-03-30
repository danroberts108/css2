let requestBtn = document?.getElementById('requestBtn');
let cancelBtn = document?.getElementById('cancelBtn');
let removeBtn = document?.getElementById('removeBtn');
let blockBtn = document?.getElementById('blockBtn');

let userid = document.getElementById('thisuserid').value;

function requestFriend() {

}

function removeFriend() {

}

function blockUser() {

}

function ajaxRequst(userid, requestType) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', "userFunctions.php?userid=" + userid + "&type=" + requestType + '&ajaxToken=' + token);

    xhr.onreadystatechange = function () {
        let OK = 200;
        let DONE = 4;
        if (xhr.status === OK && xhr.readyState === DONE) {

        }
    };
}

requestBtn?.addEventListener('click', requestFriend(), false);
removeBtn?.addEventListener('click', removeFriend, false);
blockBtn?.addEventListener('click', blockUser, false);