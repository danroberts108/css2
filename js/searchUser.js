let searchbox = document.getElementById('searchbox');
let hint = document.getElementById('liveSearch');

function search() {
    let term = searchbox.value;

    if (term === "" || term == null) {
        if (hint.hasChildNodes()) {
            hint.firstChild.remove();
        }
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'searchUser.php?term=' + term);

    xhr.onreadystatechange = function () {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE && xhr.status === OK) {
            let resultArray = JSON.parse(xhr.responseText);
            if (hint.hasChildNodes()) {
                hint.firstChild.remove();
            }
            if (resultArray != null) {
                let list = document.createElement("div");
                list.classList.add('list-group');
                for (let i = 0; i < resultArray.length; i++) {
                    let result = document.createElement('a');
                    result.classList.add('list-group-item');
                    result.classList.add('list-group-item-action')
                    result.classList.add('search-infront');
                    result.setAttribute('href', '#');
                    let item = JSON.parse(resultArray[i]);
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

searchbox.addEventListener('keyup', search, false);