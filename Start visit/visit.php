<?php
    session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Start a visit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" >
    <link rel="stylesheet" href="./OpenLayers/ol.css" type="text/css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="visit.css">

    <?php
    $logged = TRUE;
    $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password") or die("Could not connect to postgres: " .preg_last_error());
    // 0. se l'utente non è loggato riceverà opere star
    if(!isset($_SESSION['current_user'])) {
        $user_preference = 'star';
        $logged = FALSE;
    }
    else {
        // 1. recupero l'utente dalla sessione
        $email = $_SESSION['current_user'];
        // 2. imparo la sua preferenza!
        $query_preference = 'select categoria from utente where email=$1';
        $user_preference = strtolower(pg_fetch_array(pg_query_params($dbconn,$query_preference,array($email)), null , PGSQL_ASSOC)['categoria'])
                       or die ('Query failed: ' .preg_last_error());
    }
    // 3. restituisco le migliori opere in base alla preferenza
    $query_artworks = 'select * from opera where categoria=$1 and latitudine is not null order by voto desc limit 7';
    $result = pg_query_params($dbconn,$query_artworks,array($user_preference)) 
              or die ('Query failed: ' .preg_last_error());
    $suggestions = array();
    while ($suggestion = pg_fetch_array($result, null, PGSQL_ASSOC)) { 
        $suggestions[] = $suggestion;
    }
    ?>

    <!-- Salvo tutte le info sui suggerimenti -->
    <script type="text/javascript">
        var logged_user = <?php echo json_encode($logged)?>;
        // primo suggerimento
        var art1 = <?php echo json_encode($suggestions[0]['nome'])?>;
        var aut1 = <?php echo json_encode($suggestions[0]['autore'])?>;
        var lng1 = <?php echo $suggestions[0]['longitudine']?>;
        var lat1 = <?php echo $suggestions[0]['latitudine']?>;
        // secondo suggerimento
        var art2 = <?php echo json_encode($suggestions[1]['nome'])?>;
        var aut2 = <?php echo json_encode($suggestions[1]['autore'])?>;
        var lng2 = <?php echo $suggestions[1]['longitudine']?>;
        var lat2 = <?php echo $suggestions[1]['latitudine']?>;
        // terzo suggerimento
        var art3 = <?php echo json_encode($suggestions[2]['nome'])?>;
        var aut3 = <?php echo json_encode($suggestions[2]['autore'])?>;
        var lng3 = <?php echo $suggestions[2]['longitudine']?>;
        var lat3 = <?php echo $suggestions[2]['latitudine']?>;
        // quarto suggerimento
        var art4 = <?php echo json_encode($suggestions[3]['nome'])?>;
        var aut4 = <?php echo json_encode($suggestions[3]['autore'])?>;
        var lng4 = <?php echo $suggestions[3]['longitudine']?>;
        var lat4 = <?php echo $suggestions[3]['latitudine']?>;
        // quinto suggerimento
        var art5 = <?php echo json_encode($suggestions[4]['nome'])?>;
        var aut5 = <?php echo json_encode($suggestions[4]['autore'])?>;
        var lng5 = <?php echo $suggestions[4]['longitudine']?>;
        var lat5 = <?php echo $suggestions[4]['latitudine']?>;
        // sesto suggerimento
        var art6 = <?php echo json_encode($suggestions[5]['nome'])?>;
        var aut6 = <?php echo json_encode($suggestions[5]['autore'])?>;
        var lng6 = <?php echo $suggestions[5]['longitudine']?>;
        var lat6 = <?php echo $suggestions[5]['latitudine']?>;
        // settimo suggerimento
        var art7 = <?php echo json_encode($suggestions[6]['nome'])?>;
        var aut7 = <?php echo json_encode($suggestions[6]['autore'])?>;
        var lng7 = <?php echo $suggestions[6]['longitudine']?>;
        var lat7 = <?php echo $suggestions[6]['latitudine']?>;
    </script>

  </head>
    <div class="prova">
    <body onload='return disable_buttons_for_non_loggedin_user()'>

    <div class="w3-bar">
        <div class="element">
            <div id='divAccount' class ="account">Account <img src="../Images/Microsoft_Account.svg.png" width="40" height="40">       
                <div class="dropdown-content">
                    <a href="../EditAccount/editAccount.php"> Edit Account </a>
                    <a href="../EditPassword/editPassword.php"> Edit Password</a>
                </div>  
            </div>
        </div>     
        <input type="button" class="logo" id='btnHome' onclick='return back_to_home();'>
                
        <div id='menu' class="menu">
            <a href="../Start visit/visit.php" class="element">Start visit or come back to your tour! 🗺️ </a>
            <a href ="../FindArtwork/findArtwork.html" class="element" >Look for an artwork 🔎</a>
            <a href ="../AddArtwork/addArtwork.php" class="element">Add an artwork 🖼️</a> 
        </div>
    </div>

        <span class="text1" align="center">
            Enjoy your tour!
        </span>
        <br>
        <div class="text3">
            Select time to spend to wander 
        </div>
        <!-- <div class="custom-select" style="width:200px;"> -->
            <div class="timeperiod">
            <select class="time" name="time" id="time" onchange="return reduce_visit()">
                <option value="allday"> All day </option>
                <option value="halfday"> Half day </option>
                <option value="couplehours"> Couple hours </option>
            </select>
        </div>
        <br>

    <div class="show" style="display: flex;flex-direction: row">
      <input type="checkbox" id="checkbox" checked> Show suggestions on Map </input>
    </div>
    <div id="map" class="map"><div id="popup"></div></div>
    <script src="./OpenLayers/ol.js"></script>

    <!-- Caricamento dinamico delle opere -->
    <span class="text2" align="center">
            According to your preferences you would like to visit...
        </span>
    <div class="suggestions">
        <br> <br>
    
        <?php 
            $name = $suggestions[0]['nome'];
            $author = $suggestions[0]['autore'];
            $urlname = urlencode($suggestions[0]['nome']);
            $urlauthor = urlencode($suggestions[0]['autore']);
            echo "<a id=link1 href=../ArtworkDetails/details.php?name=$urlname&author=$urlauthor> $name </a>";
        ?><br><br>
    
        <?php 
            $name = $suggestions[1]['nome'];
            $author = $suggestions[1]['autore'];
            $urlname = urlencode($suggestions[1]['nome']);
            $urlauthor = urlencode($suggestions[1]['autore']);
            echo "<a id=link2 href=../ArtworkDetails/details.php?name=$urlname&author=$urlauthor> $name </a>";
        ?><br><br>

        <?php 
            $name = $suggestions[2]['nome'];
            $author = $suggestions[2]['autore'];
            $urlname = urlencode($suggestions[2]['nome']);
            $urlauthor = urlencode($suggestions[2]['autore']);
            echo "<a id=link3 href=../ArtworkDetails/details.php?name=$urlname&author=$urlauthor> $name </a>";
        ?><br><br>

        <?php 
            $name = $suggestions[3]['nome'];
            $author = $suggestions[3]['autore'];
            $urlname = urlencode($suggestions[3]['nome']);
            $urlauthor = urlencode($suggestions[3]['autore']);
            echo "<a id=link4 href=../ArtworkDetails/details.php?name=$urlname&author=$urlauthor> $name </a>";
        ?><br><br>

        <?php 
            $name = $suggestions[4]['nome'];
            $author = $suggestions[4]['autore'];
            $urlname = urlencode($suggestions[4]['nome']);
            $urlauthor = urlencode($suggestions[4]['autore']);
            echo "<a id=link5 href=../ArtworkDetails/details.php?name=$urlname&author=$urlauthor> $name </a>";
        ?><br><br>

        <?php 
            $name = $suggestions[5]['nome'];
            $author = $suggestions[5]['autore'];
            $urlname = urlencode($suggestions[5]['nome']);
            $urlauthor = urlencode($suggestions[5]['autore']);
            echo "<a id=link6 href=../ArtworkDetails/details.php?name=$urlname&author=$urlauthor> $name </a>";
        ?><br><br>

        <?php 
            $name = $suggestions[6]['nome'];
            $author = $suggestions[6]['autore'];
            $urlname = urlencode($suggestions[6]['nome']);
            $urlauthor = urlencode($suggestions[6]['autore']);
            echo "<a id=link7 href=../ArtworkDetails/details.php?name=$urlname&author=$urlauthor> $name </a>";
        ?><br><br>

    </div>

    <!-- Bottoni di navigazione -->
    <div class='map-navigator'>
        <div class='map-navigator-text' align="center">
            <h4><b> Navigate around <br> the map to <br> locate our suggestions! <b></h4>
        </div>
        <button class='button' id="button1" onclick="move(lng1,lat1);"><?php echo $suggestions[0]['nome']?></button> <br> <br>
        <button class='button' id="button2" onclick="move(lng2,lat2);"><?php echo $suggestions[1]['nome']?></button> <br> <br>
        <button class='button' id="button3" onclick="move(lng3,lat3);"><?php echo $suggestions[2]['nome']?></button> <br> <br>
        <button class='button' id="button4" onclick="move(lng4,lat4);"><?php echo $suggestions[3]['nome']?></button> <br> <br>
        <button class='button' id="button5" onclick="move(lng5,lat5);"><?php echo $suggestions[4]['nome']?></button> <br> <br>
        <button class='button' id="button6" onclick="move(lng6,lat6);"><?php echo $suggestions[5]['nome']?></button> <br> <br>
        <button class='button' id="button7" onclick="move(lng7,lat7);"><?php echo $suggestions[6]['nome']?></button> <br> <br>
        <button class='tourbutton' onclick="tour();"> 📸  Bring me on itinerary   📸 </button>

    </div>

    <div class='overlay-container'>
        <span class='overlay-text' id='artworkname'></span><br>
        <span class='overlay-text' id='authorname'></span><br>
    </div>

    <script src="visit.js"></script>

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
        <a href="../AboutUs/aboutUs.php" id='fe1' class="footer_element" style="margin-left: 30px;">About Us</a>
        <a href="../ContactUs/contact_us.html" id='fe2' class="footer_element" style="margin-left: 30px";>Contact Us</a>
      </div>       
    </div>
    <!-- Animazioni in JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $(".button").click(function(event){
            $(event.target).addClass("active");
    
            // La classe diventa successo dopo 3.7 sec
            setTimeout(function(){
                $(event.target).addClass("success")
            }, 3700);
    
            // Rimuovo la classe successo dopo 5 sec
            setTimeout(function(){
                $(event.target).removeClass("active");
                $(event.target).removeClass("success");
                $(event.target).removeClass("failure");
            }, 5000);
        });
    });
    </script>
  </body>
</div>
</html>
