function more_infos(artwork) {
    if (document.getElementById('btninfo').innerHTML === 'Hide infos' )
        return true
    
    // preparo i parametri per la chiamata ajax
    var art = new FormData();
    art.append('art', artwork);

    // chiamata post ajax 
    var httpRequest = new XMLHttpRequest()
    httpRequest.open("POST", "infos.php", true)

    // callback
    httpRequest.onload = function () {
        document.getElementById('more_infos').innerHTML = this.response
    }

    // carico i parametri per lo script php
    httpRequest.send(art)

    return true
}

function updatedb(mark) {
    // preparo i parametri per la chiamata ajax
    var data = new FormData();
    data.append('mark', mark);
    data.append('artwork', artwork);

    // ajax post call 
    var httpRequest = new XMLHttpRequest()
    httpRequest.open("POST", "updatedb.php", true)

    // callback function
    httpRequest.onload = function () {
        alert('Thank you for voting this artwork!')
    }

    // carico i parametri per lo script php
    httpRequest.send(data)
    
    return true
}


function modify_view() {
    if (!islogged) {
        document.getElementById("edit_btn").style.visibility = "hidden"
        document.getElementById("menu").style.visibility = "hidden"
        document.getElementById('account').style.visibility = "hidden"
    } else if (isAdmin==="f") {
        document.getElementById("edit_btn").style.visibility = "hidden"
        document.getElementById("menu").style.visibility = "visible"
        document.getElementById('account').style.visibility = "visible"
    } else {
        document.getElementById("edit_btn").style.visibility = "visible"
        document.getElementById("menu").style.visibility = "visible"
        document.getElementById('account').style.visibility = "visible"
    }
}


function back_to_home() {
    if(!islogged)   window.location.replace('../Homepage/homePage.html')
    else            window.location.replace('../WelcomeHomepage/welcomeHomepage.html')
}