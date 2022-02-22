<?php session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Password</title>
         <script> 
             var currentUser = <?php echo json_encode($_SESSION['current_user'])?>;
        </script> 
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" >
        <script type="text/javascript" lang="javascript" src="editPassword.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="editPassword.css">
    </head>
    <body>
        <div class="w3-bar">
            <div class="element">
                <div class ="account">Account <img src="../Images/Microsoft_Account.svg.png" width="40" height="40">       
                    <div class="dropdown-content">
                        <a href="../EditAccount/editAccount.php"> Edit Account </a>
                    </div>  
                </div>
            </div>     
            <input type="button" class="logo" id='btnHome' onclick="location.href='../WelcomeHomepage/welcomeHomepage.html'">
                    
            <div class="menu">
                <a href="../Start visit/visit.php" class="element">Start visit or come back to your tour! 🗺️ </a>
                <a href ="../FindArtwork/findArtwork.html" class="element" >Look for an artwork 🔎</a>
                <a href ="../AddArtwork/addArtwork.php" class="element">Add an artwork 🖼️</a>
            </div>
        </div>
        <br>
        <br>
        <div class ="edit">
            <br>
            <form onsubmit='validate(); return false;' action ="save.php" method="POST" name="editPassword" id='fpsw'>
                <div class="text1">
                    Edit password 
                </div>
                <br>
                <input type="password" id="currentPassword" name="currentPassword" size="30" maxlenght="30" placeholder="Current password" autocomplete="on">
                <br>
                <br>
                <input type="password" id="newPassword" name="newPassword" size="30" maxlenght="30" placeholder="New password" pattern= "(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*])(?=.*[A-Z]).{8,}" autocomplete="on"
                    onfocus="return onPassword();" onblur="return outPassword();" onkeyup="return writePassword();">
                <br>
                <div id="msg">
                    <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                    <p id="number" class="invalid">A <b>number</b></p>
                    <p id="special" class="invalid">A <b> special</b> character</p>
                    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                </div>
                <input type ="password" id="confirmPassword" name="confirmPassword" size="30" maxlenght="30" placeholder="Confirm password" autocomplete="on">
                <br>
                <br>
                <br>
                <input type="submit" value ="Save">
                <br>
                <br>
            </form>
        </div>
        <br>
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
            <div class="developers">
              <a href="../AboutUs/aboutUs.php" class="footer_element" style="margin-left: 30px;">About Us</a>
              <a href="../ContactUs/contact_us.html" class="footer_element" style="margin-left: 30px;">Contact Us</a>
            </div>       
          </div>
    </body>
</html>