<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>

        <?php
            $logged = 1;
            if(!isset($_SESSION['current_user']))
                $logged = 0;
        ?>

        <title>About Us</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="aboutUs.css">

        <script>
            var user_logged = <?php echo $logged;?> ;
            console.log(user_logged)
        </script>

        <script text='text/javascript' src='aboutUs.js'></script>
    
    </head>
    <body onload='return hide_bar_to_non_logged_in_user();'>
        <div class="w3-bar" id='upperBar'>
            <div class="element">
                <div id='account' class ="account">Account <img src="../Images/Microsoft_Account.svg.png" width="40" height="40">       
                    <div class="dropdown-content">
                        <a href="../EditAccount/editAccount.php"> Edit Account </a>
                        <a href="../EditPassword/editPassword.php"> Edit Password</a>
                    </div>  
                </div>
            </div>     
            <input type="button" class="logo" id='btnHome' onclick='return back_to_home()'>
                    
            <div id='menu' class="menu">
                <a href="../Start visit/visit.php" class="element">Start visit or come back to your tour! 🗺️ </a>
                <a href ="../FindArtwork/findArtwork.html" class="element" >Look for an artwork 🔎</a>
                <a href ="../AddArtwork/addArtwork.php" class="element">Add an artwork 🖼️</a>
            </div>
        </div>
    
        <br> <br>

        <div class ="About">
            About us 
        </div>
            <br>
        <div class='paragraph'>
            Hi! We are a group of three Computer Engineering students of 'La Sapienza' university in Rome. </br>
            Our site's basic idea is to make the Rome's visits easier to organize </br>
            so that you can admire the beauty of the city in its entirety. <br>
            smART Wandering is a site that allows users to receive suggestions regarding the artworks
            to visit in the city of Rome, <br>
            according to their preferences.
        </div> 

        <div class="w3-footer_bar">
            <div id="social_sez" class="social_sez" text-align="center">
              <h5>Follow us on:</h5>
                <a href="https://www.facebook.com/Smart-Wandering-106566171072452/" class="fa fa-facebook"></a>
                <a href="https://www.instagram.com/smartwanderinginrome/?hl=it" class="fa fa-instagram"></a>
                <a href="#" class="fa fa-youtube-play"></a>
            </div>
      
            <div class="logo_sez" align="left">
              <img id="foto_logo_sez" src="../Images/sapienza.png" alt="logo sapienza">
            </div>
            <div id='dev' class="developers">
              <a href="../contactUs/contact_us.html" id='fe1' class="footer_element" style="margin-left: 30px;">Contact Us</a>
            </div>       
          </div>
    </body>
</html>