function validate() {
    // check if new psw and confirm psw are the same
    var psw1 = document.getElementById('newPassword');
    var psw2 = document.getElementById('confirmPassword');
    if(!(psw2.value == psw1.value)){
        window.alert("New password do not match");
        return false;
    }

    // controlla se nuova psw e conferma che psw sono uguali
    const currentPassword = document.getElementById('currentPassword').value
    const user = currentUser

    // prepara il testo da inviare allo script
    var params = new FormData()
    params.append('user', user)
    params.append('inserted_psw', currentPassword)

    // chiamata ajax
    var httpRequest = new XMLHttpRequest()
    httpRequest.open("POST", "check_psw.php", true)

    // funzione callback 
    httpRequest.onload = function () {
            var res = JSON.parse(this.response).message;
            if (res === 'Wrong password, please try again') {
                alert('Password incorrect: please try again')
            }
            else {
                alert("Corretto")
                window.location.replace('../WelcomeHomePage/welcomeHomepage.html')
                document.getElementById('fpsw').submit()
            }
        }

    // invia parametri allo script php
    httpRequest.send(params)
}
function onPassword(){
    document.getElementById("msg").style.display = "block";
    window.scrollTo(0,document.body.scrollHeight);
}

function outPassword(){
    document.getElementById("msg").style.display = "none";
}
psw = document.getElementById("newPassword");

function writePassword(){
    psw = document.getElementById("newPassword");

    var lowerCaseLetters = /[a-z]/g;
    var letter = document.getElementById("letter");
    if(psw.value.match(lowerCaseLetters)){
        letter.classList.remove("invalid");
        letter.classList.add("valid");
    } else{
        var letter = document.getElementById("letter");
        letter.classList.remove("valid");
        letter.classList.add("invalid");
    }

    var upperCaseLetters = /[A-Z]/g;
    var capital = document.getElementById("capital");
    if(psw.value.match(upperCaseLetters)){
        capital.classList.remove("invalid");
        capital.classList.add("valid");
    } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");        
    }

    var number = /[0-9]/g;
    var num = document.getElementById("number");
    if(psw.value.match(number)){
        num.classList.remove("invalid");
        num.classList.add("valid");
    } else {
        num.classList.remove("valid");
        num.classList.add("invalid");
    } 

    var spec = /[!@#$%^&*]/g;
    var s = document.getElementById("special");
    if(psw.value.match(spec)){
        s.classList.remove("invalid");
        s.classList.add("valid");
    } else {
        s.classList.remove("valid");
        s.classList.add("invalid");
    }

    var len = document.getElementById("length");
    if(psw.value.length >= 8){
        len.classList.remove("invalid");
        len.classList.add("valid");
    } else {
        len.classList.remove("valid");
        len.classList.add("invalid");
    }
}

