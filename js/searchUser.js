let searchbox = document.getElementById('searchbox');

function search() {
    let term = searchbox.value;

    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'searchUser.php?term=' + term);

    xhr.onreadystatechange = function () {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE && xhr.status === OK) {
            console.log(xhr.responseText);
            let resultArray = JSON.parse(xhr.responseText);
            console.log(resultArray);
        }
    };

    xhr.send(null);
}

searchbox.addEventListener('keyup', search, false);