function send_email() {
    const payload = document.getElementById("contact_area").value
    if (payload == '') return false


    //preparo il text da inviare allo script php
    var text = new FormData();
    text.append('text', payload);

    //chiamata ajax post 
    var httpRequest = new XMLHttpRequest()
    httpRequest.open("POST", "contact_us.php", true)

    // funzione callback
    httpRequest.onload = function () {
            var res = JSON.parse(this.response);
            (res.status === 200)?sended=true:sended=false
        }

    //invio parametri allo script php
    httpRequest.send(text)
    
    return true
}


function back_to_home() {
    window.location.replace('../WelcomeHomepage/WelcomeHomepage.html')
}
