function validatePassword(){
    var psw = document.getElementById("password");
    var psw1 = document.getElementById("password1");
    if(!(psw.value == psw1.value)){
        window.alert("Password do not match");
        return false;
    }
    return true;
}

function onPassword(){
    document.getElementById("msg").style.display = "block";
    window.scrollTo(0,document.body.scrollHeight);
}

function outPassword(){
    document.getElementById("msg").style.display = "none";
}

psw = document.getElementById("password");

function writePassword(){
    psw = document.getElementById("password");

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

