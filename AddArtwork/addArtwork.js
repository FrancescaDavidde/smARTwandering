function hide_if_is_not_admin() {
    if (!admin) {
        document.getElementById('admininfo').style.visibility = 'hidden'
        //i campi dell'admin non sono required perchè sono un semplice user
        document.getElementById('timePeriod').removeAttribute('required', '')
        document.getElementById('dimensions').removeAttribute('required', '')
        document.getElementById('vote').removeAttribute('required', '')
        document.getElementById('valutations').removeAttribute('required', '')
        document.getElementById('location').removeAttribute('required', '')
        document.getElementById('lat').removeAttribute('required', '')
        document.getElementById('long').removeAttribute('required', '')
    }
}


function save_artwork() {
    //logica di convalida
    if(document.addArtwork.category.value =="choose") {
        alert("Choose a category! 🛎️");
        return false;
    }

    var data = new FormData();

    //campi dello user
    var name = document.getElementById('name').value;
    var author = document.getElementById('author').value;
    var e = document.getElementById('category')
    var category = e.options[e.selectedIndex].value;

    if (admin) {
        console.log('admin')
        //l'admin inserisce dei campi in più rispetto allo user
        var timePeriod = document.getElementById('timePeriod').value
        var dimensions = document.getElementById('dimensions').value
        var vote = document.getElementById('vote').value
        if (vote < 1 || vote > 6)   return false
        var valutations = document.getElementById('valutations').value
        var location = document.getElementById('location').value
        var imm1 = document.getElementById('imm1').value
        var imm2 = document.getElementById('imm2').value
        var imm3 = document.getElementById('imm3').value
        var imm4 = document.getElementById('imm4').value
        var imm5 = document.getElementById('imm5').value
        var lat = document.getElementById('lat').value
        var long = document.getElementById('long').value
    }

    //campi dello user
    data.append('name', name)
    data.append('author', author)
    data.append('category', category)
    //campi dell'admin
    if (admin) {
        data.append('timePeriod', timePeriod)
        data.append('dimensions', dimensions)
        data.append('vote', vote)
        data.append('valutations', valutations)
        data.append('location', location)
        data.append('imm1', imm1)
        data.append('imm2', imm2)
        data.append('imm3', imm3)
        data.append('imm4', imm4)
        data.append('imm5', imm5)
        data.append('lat', lat)
        data.append('long', long)
    }

    //chiamata ajax
    var httpRequest = new XMLHttpRequest()
    httpRequest.open("POST", "save_my_artwork.php", true)

    //funzione callback
    httpRequest.onload = function () {
        var res = JSON.parse(this.response)
        if (res.status === 200) {
            alert('Success! ' + res.message)
            window.location.replace('../WelcomeHomePage/welcomeHomepage.html')
        }
        else if (res.status === 400)
            alert('No need to bother: ' + res.message)
        else
            alert('Error : ' + res.message)
    }

    //invio parametri allo script php
    httpRequest.send(data)
    
    return true
}


