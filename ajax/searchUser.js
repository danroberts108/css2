let searchbox = document.getElementById('searchbox');
let hint = document.getElementById('liveSearch');
let limitbox = document.getElementById('limit');
let usernameCheck = document.getElementById('usernameCheck');
let fnameCheck = document.getElementById('fnameCheck');
let lnameCheck = document.getElementById('lnameCheck');

let usernameChecked = usernameCheck?.checked;
let fnameChecked = fnameCheck?.checked;
let lnameChecked = lnameCheck?.checked;

function search() {
    let term = searchbox.value;
    let limit = limitbox.value;
    let typeString = "";
    let needComma = false;

    //Checks if a search term has been entered
    if (term === "" || term == null) {
        if (hint.hasChildNodes()) {
            hint.firstChild.remove();
        }
        return;
    }

    let viewHeight = window.innerHeight;

    //Logic to limit results to screen height for viewability
    if (limit == null || limit === '') {
        if (viewHeight < 750) {
            viewHeight -= 264;
            let screenLimit = viewHeight / 100;
            screenLimit = Math.floor(screenLimit);
            limit = screenLimit;
        } else {
            limit = 5;
        }
    }

    //Checks if the username box is checked and adds it to the query
    if (usernameChecked === true) {
        typeString += 'username';
        needComma = true;
    }

    //Checks if the fname box is checked and adds it to the query
    if (fnameChecked === true) {
        if (needComma) {
            typeString+= ',';
        }
        typeString += 'fname';
        needComma = true;
    }

    //Checks if the lname box is checked and adds it to the query
    if (lnameChecked === true) {
        if (needComma) {
            typeString += ',';
        }
        typeString += 'lname';
    }

    //Opens the ajax connection
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'searchUser.php?term=' + term + '&ajaxToken=' + token + '&limit=' + limit + '&searchType=' + typeString);

    xhr.onreadystatechange = function () {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE && xhr.status === OK) {
            let response = xhr.responseText;
            //Checks if the response has returned false by to failing any validations
            if (response === "false") {
                console.log('returned false');
                return;
            }
            //Creates an array with the json parsed results
            let resultArray = JSON.parse(response);
            //Removes previous search results from the popup search window
            if (hint.hasChildNodes()) {
                //hint.firstChild.remove();
                document.getElementById('searchDiv').remove();
            }
            //Checks if the search returned no results
            if (resultArray != null) {
                //Creates the list div in the document
                let list = document.createElement("div");
                //Sets the div ID
                list.id = 'searchDiv';
                //Adds the class 'list-group' for css formatting
                list.classList.add('list-group');
                //Creates a result item for each returned result and then appends it inside the list div
                for (let i = 0; i < resultArray.length; i++) {
                    let result = document.createElement('a');
                    let item = resultArray[i];
                    item.id = 'result' + i;
                    result.classList.add('list-group-item', 'list-group-item-action', 'search-infront');
                    result.setAttribute('href', 'user.php?userid=' + item._userid);
                    result.innerHTML = '<div class="container">' +
                        '   <div class="row">' +
                        '    <div class="col col-md-auto">' +
                        '           <div class="row">' +
                        '             <div class="container">' +
                        '                 <img src="images/' + item._photo + '" alt="" class="search-img">' +
                        '             </div>' +
                        '           </div>' +
                        '     </div>' +
                        '     <div class="col">' +
                        '          <div class="row">' +
                        '             <h5><strong>' + item._username + '</strong> (' + item._userid + ')</h5>' +
                        '           </div>' +
                        '           <div class="row">' +
                        '               <p>' + item._fname + ' ' + item._lname + '</p>' +
                        '           </div>' +
                        '       </div>' +
                        '   </div>' +
                        '</div>';
                    list.appendChild(result);
                }
                //Appends the full results list to the hint div that is in the DOM
                hint.appendChild(list);
            }
        }
    };
    //Sends the request to the specified script
    xhr.send(null);
}

//Function to remove the live search list
function onUnfocus() {
    if (hint.hasChildNodes()) {
        //setTimeout used to stop the element being removed before the user can click one of the results and go to the user page
        //TODO find better way to handle this
        setTimeout(() => {hint.firstChild.remove();}, 500);
    }
}

//Function to keep track of username checkbox
function usernameCheckChange() {
    usernameChecked = !usernameChecked;
}

//Function to keep track of fname checkbox
function fnameCheckChange() {
    fnameChecked = !fnameChecked;
}

//Function to keep track of lname checkbox
function lnameCheckChange() {
    lnameChecked = !lnameChecked;
}

//Adds the event listeners to the search box element only if they exist on the page with the ?. function
searchbox?.addEventListener('keyup', search, false);
searchbox?.addEventListener('focusin', search, false);
searchbox?.addEventListener('focusout', onUnfocus, false);

//Adds the event listeners to the search param checkboxes only if they exist on the page with the ?. function
usernameCheck?.addEventListener('change', usernameCheckChange, false);
fnameCheck?.addEventListener('change', fnameCheckChange, false);
lnameCheck?.addEventListener('change', lnameCheckChange, false);