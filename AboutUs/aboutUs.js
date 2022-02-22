function hide_bar_to_non_logged_in_user() {
    if(!user_logged) {
        document.getElementById('account').style.visibility = 'hidden'
        document.getElementById('menu').style.visibility = 'hidden'
        document.getElementById('dev').style.visibility = 'hidden'
    }
}

function back_to_home() {
    if(!user_logged) {
        window.location.replace('../Homepage/homePage.html')
    } else {
        window.location.replace('../WelcomeHomepage/welcomeHomepage.html')
    }
}