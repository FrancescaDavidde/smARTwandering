function send_password() {
    // preparo il text da inviare allo script php
    var data = new FormData();
    var utente = document.getElementById('email').value;
    
    data.append('utente', utente);
  
    // chiamata ajax post 
    var httpRequest = new XMLHttpRequest()
    httpRequest.open("POST", "forgottenPassword.php", true)

    // funzione callback
    httpRequest.onload = function () {
        alert('An email was sent to ' +utente+ ' with a new password')
    }

    // invio parametri allo script php
    httpRequest.send(data)
    
    return true
}