<?php session_start();
?>
<!doctype html>
<html>
    <head><title>Edit Account</title>
        <link rel="stylesheet" text='text/css' href="editAccount.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

         <script type="text/javascript" lang="javascript" src="editAccount.js"></script>
    </head>
    <?php 
        $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
        or die ('Could not connect: ' .pg_last_error());
        
        $q1 = "select * from utente where email = $1";
        $result = pg_query_params($dbconn, $q1, array($_SESSION['current_user']));
        $line = pg_fetch_array($result, null, PGSQL_ASSOC);
        $name = $line['nome'];
        $surname = $line['cognome'];
        $username = $line['username'];
        $email = $line['email'];
        $username = $line['username'];
        $password = $line['password'];
        $category = $line['categoria'];
    ?>

    <script> var category = <?php echo json_encode($category) ?>; </script>
    <div class="prova">
    <body onload="return categoriaSelezionata(category)";>   
    <div class="w3-bar">
            <div class="element">
                <div class ="account">Account <img src="../Images/Microsoft_Account.svg.png" width="40" height="40">       
                    <div class="dropdown-content">
                        <a href="../EditPassword/editPassword.php"> Edit Password </a>
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

        <div class="edit">
            <form action="save.php" method="post" id="users">
                <br>
                <div class='text1'>
                    Edit account
                </div>
                <br>
                <input type="text" id="name" name="name" value=<?php echo json_encode($name) ?>>
                <br>
                <input type="text" id="surname" name="surname" value =<?php echo json_encode($surname) ?>>
                <br>
                <br>
                <input type="text" id="username" name="username" value = <?php echo json_encode($username) ?>>
                <br>
                <input type="email" id="email" name="email" value=<?php echo json_encode($email) ?> readonly>
                <br>
                <input type="password" id="password" name="password" value = <?php echo json_encode($password)?> readonly>
                <br>
                <br>
                    <select class="category" id="category" name ="category">
                        <option value="Categories">Category</option>
                        <option value="Architecture">Architecture</option>
                        <option value="Painting">Painting</option>
                        <option value="Sculpture">Sculpture</option>
                    </select>
               
                <br> <br> <br>
                <input type="submit" id="save" name="save" value="Save Changes">
                <br>
                <br>
                <a href="deleteAccount.php"> <input type="button" id="delete" value="Delete my account"> </a> 
                <br>
                <br>
            </form>
        </div>  
        <br>
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
    </div>
</html>



            
                

    