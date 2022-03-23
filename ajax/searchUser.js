let searchbox = document.getElementById('searchbox');
let hint = document.getElementById('liveSearch');

function search() {
    let term = searchbox.value;
    let limit = 5;

    if (term === "" || term == null) {
        if (hint.hasChildNodes()) {
            hint.firstChild.remove();
        }
        return;
    }

    let viewHeight = document.getElementById('page').clientHeight;
    let viewHeightRem = viewHeight / 16;


    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'searchUser.php?term=' + term + '&ajaxToken=' + token + '&limit=' + limit);

    xhr.onreadystatechange = function () {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE && xhr.status === OK) {
            let response = xhr.responseText;
            if (response === "false") {
                console.log('returned false');
                return;
            }
            let resultArray = JSON.parse(response);
            if (hint.hasChildNodes()) {
                hint.firstChild.remove();
            }
            if (resultArray != null) {
                let list = document.createElement("div");
                list.classList.add('list-group');
                for (let i = 0; i < resultArray.length; i++) {
                    let result = document.createElement('a');
                    let item = JSON.parse(resultArray[i]);
                    result.classList.add('list-group-item', 'list-group-item-action', 'search-infront');
                    result.setAttribute('href', 'user.php?userid=' + item.userid);
                    result.innerHTML = '<div class="container">' +
                        '   <div class="row">' +
                        '    <div class="col col-md-auto">' +
                        '           <div class="row">' +
                        '             <div class="container">' +
                        '                 <img src="images/' + item.photo + '" alt="" class="search-img">' +
                        '             </div>' +
                        '           </div>' +
                        '     </div>' +
                        '     <div class="col">' +
                        '          <div class="row">' +
                        '             <h5><strong>' + item.username + '</strong> (' + item.userid + ')</h5>' +
                        '           </div>' +
                        '           <div class="row">' +
                        '               <p>' + item.fname + ' ' + item.lname + '</p>' +
                        '           </div>' +
                        '       </div>' +
                        '   </div>' +
                        '</div>';
                    list.appendChild(result);
                }
                hint.appendChild(list);
            }
        }
    };

    xhr.send(null);
}

function onUnfocus() {
    if (hint.hasChildNodes()) {
        hint.firstChild.remove();
    }
}

searchbox.addEventListener('keyup', search, false);
searchbox.addEventListener('focusin', search, false);
//searchbox.addEventListener('focusout', onUnfocus, false);