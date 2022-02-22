<?php
    session_start();
?>
<!DOCTYPE html>
<html>

   <head>

   <meta name="viewport" content="width=device-width, initial-scale=1"/>
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <?php
        //interrogo il DB per capire se utente è admin
        $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password") or die("Could not connect to postgres: " .preg_last_error());
        if (isset($_SESSION['current_user'])) {
            $logged = 1;
            $email = $_SESSION['current_user'];
            $qadmin="select admin from utente where email = $1";
            $resultAdmin = pg_query_params($dbconn,$qadmin,array($email)) or die ('Query failed: ' .preg_last_error());
            $infosAdmin = pg_fetch_array($resultAdmin, null, PGSQL_ASSOC);
        } else {
            $infosAdmin['admin'] = "f";
            $logged = 0;
        }
        //prendo nome e autore dal DB
        $name = $_GET['name'];
        $author = $_GET['author'];
        $query = 'SELECT * FROM opera WHERE nome=$1 AND autore=$2';
        $result = pg_query_params($dbconn,$query,array($name,$author)) or die ('Query failed: ' .preg_last_error());
        $infos = pg_fetch_array($result, null, PGSQL_ASSOC);
    ?>

    <script src='https://code.jquery.com/jquery-3.1.0.min.js'></script>
    <script type='text/javascript' src='lightbox2-2.11.1/lightbox2-2.11.1/dist/js/lightbox-plus-jquery.min.js'></script>
    <script type='text/javascript' src='details.js'></script>
    <script type="text/javascript" src='Vue/vue.min.js'></script>

    <script> var artwork = <?php echo json_encode($name)?>;</script>
    <script> var mark = <?php echo $infos['voto']?>; </script>
    <script> var valutations = <?php echo $infos['valutazioni']?>; </script> 
    
    <script type="text/javascript"> 
        var isAdmin = <?php echo json_encode($infosAdmin['admin'])?>;
        var islogged = <?php echo $logged?>;
        console.log(isAdmin)
        console.log(islogged)
    </script>

    <link rel="stylesheet" href="details.css">
    <link rel="stylesheet" href="star_style.css">
    <link rel="stylesheet" type='text/css' href="lightbox2-2.11.1/lightbox2-2.11.1/dist/css/lightbox.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    

   </head>

   <body onload='return modify_view();'>
        <div class="w3-bar">
                <div class="element">
                    <div id='account' class ="account">Account <img src="../Images/Microsoft_Account.svg.png" width="40" height="40">       

                        <div class="dropdown-content">
                            <a href="../EditAccount/editAccount.php"> Edit Account </a>
                            <a href="../EditPassword/editPassword.php"> Edit Password</a>
                        </div>  
                    </div>
                </div>

                
                <input type="button" class="logo" id='btnHome' onclick="return back_to_home()">

                <div id='back'>
                    <a href="../Start visit/visit.php" class="element">Start visit or come back to your tour! 🗺️ </a>
                </div> 
                
                <div id='menu' class="menu">
                    <a href ="../FindArtwork/findArtwork.html" class="element" >Look for an artwork 🔎</a>
                    <a href ="../AddArtwork/addArtwork.php" class="element">Add an artwork 🖼️</a>
                </div>
        </div>
       

      

        <div class="tutto">
            <div class='gallery'>
              
                <div class="divText">
                <div class="nome"><?php echo $name ?> Details </div>
                <br>
                <br>
                    <h3>Name:</h3> <p style="display:inline"> <?php echo $infos['nome']?> <p>
                    <h3>Author:</h3> <p style="display:inline"> <?php echo $infos['autore']?> <p>
                    <h3>TimePeriod:</h3> <p style="display:inline"> <?php echo $infos['periodo']?> <p>
                    <h3>Dimensions:</h3> <p style="display:inline"> <?php echo $infos['dimensioni']?> <p>
                    <h3>Category:</h3> <p style="display:inline"> <?php echo $infos['categoria']?> <p>
                    <div id='val1'>
                        <h3>Vote:</h3> <p style="display:inline"> {{vote}} <p>
                        <h3>Valutations:</h3> <p style="display:inline"> {{val}} <p>
                        <h3>Place and address:</h3> <p style="display:inline"><?php echo $infos['indirizzo']?> </p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="rating"> 
                                    <input type="radio" name="star" id="star1" v-on:click="incrementVal(); updateMark(5)" 
                                    onclick='return updatedb(5)'> <label for="star1"></label>
                                    <input type="radio" name="star" id="star2" v-on:click="incrementVal(); updateMark(4)" 
                                    onclick='return updatedb(4)'> <label for="star2"></label>
                                    <input type="radio" name="star" id="star3" v-on:click="incrementVal(); updateMark(3)" 
                                    onclick='return updatedb(3)'> <label for="star3"></label>
                                    <input type="radio" name="star" id="star4" v-on:click="incrementVal(); updateMark(2)" 
                                    onclick='return updatedb(2)'> <label for="star4"></label>
                                    <input type="radio" name="star" id="star5" v-on:click="incrementVal(); updateMark(1)" 
                                    onclick='return updatedb(1)'> <label for="star5"></label>
                                </div>
                        
                         
                    </div>         
                </div>
                
            <br>
            <a href=<?php echo $infos['foto1']?> data-lightbox='mygallery' data-title='<?php echo $infos['nome']?>'> 
                    <img class="artwork_image" alt=<?php echo $infos['nome']?> src= <?php echo $infos['foto1']?>> 
                </a>
                <a href=<?php echo $infos['foto2']?> data-lightbox='mygallery' data-title='<?php echo $infos['nome']?>'> 
                    <img class="artwork_snapshots" alt=<?php echo $infos['nome']?> src= <?php echo $infos['foto2']?>> 
                </a>
                <a href=<?php echo $infos['foto3']?> data-lightbox='mygallery' data-title='<?php echo $infos['nome']?>'> 
                    <img class="artwork_snapshots" alt=<?php echo $infos['nome']?> src= <?php echo $infos['foto3']?>> 
                </a>
                <a href=<?php echo $infos['foto4']?> data-lightbox='mygallery' data-title='<?php echo $infos['nome']?>'> 
                    <img class="artwork_snapshots" alt=<?php echo $infos['nome']?> src= <?php echo $infos['foto4']?>> 
                </a>
                <a href=<?php echo $infos['foto5']?> data-lightbox='mygallery' data-title='<?php echo $infos['nome']?>'> 
                    <img class="artwork_snapshots" alt=<?php echo $infos['nome']?> src= <?php echo $infos['foto5']?>> 
                </a>

                <div class="container">
                    <div class="rate" id="val1">
                                <div class="valutation"> 
                                    <h4>   How was it?<img class="stella" src="../Images/stella.gif"></h4>
                                <br>
                                </div>  
                    </div>
                </div> 

           
            <?php
                        $name = $_GET['name'];
                        $author = $_GET['author']; 
                        $urlname = urlencode($name);
                        $urlauthor = urlencode($author); 
                        echo "<input type='button' id='edit_btn' onclick=(location.href='../EditArtwork/editArtwork.php?name=$urlname&author=$urlauthor') value='Edit'>";
                        ?> 
                        <div class='infos'>
                    <button type="button" id='btninfo' class="show" onclick="more_infos(artwork)">
                    Give me more informations about this artwork
                    </button>
                    <div class='more_infos' id='more_infos'>  </div>
            </div>

           
            <div class="footer">
            <div id="social_sez" class="social_sez">
                <h5>Follow us on:</h5>
                <a href="https://www.facebook.com/Smart-Wandering-106566171072452/" class="fa fa-facebook"></a>
                <a href="https://www.instagram.com/smartwanderinginrome/?hl=it" class="fa fa-instagram"></a>
                <a href="#" class="fa fa-youtube-play"></a>
            </div>

            
                <div class="logo_sez" align="left">
                    <img id="foto_logo_sez" src="../Images/sapienza.png" alt="logo sapienza">
                </div>
            <div class="developers">
                    <a href="../AboutUs/aboutUs.php" class="footer_element">About Us</a>
                    <a href="../ContactUs/contact_us.html" class="footer_element">Contact Us</a>
            </div>
           
        </div>
    </div>
        </body>
   

   <script>
        $(document).ready(function() { 
            $('#btninfo').click(function() {
                if ($('#btninfo').attr("class") === "show") {
                    $('#btninfo').text('Hide informations about this artwork')
                    $('#more_infos').fadeIn(3000)
                    $("#btninfo").removeClass("show")
                    $("#btninfo").addClass("hide")
                }
                else {
                    $('#btninfo').text('Give me more informations about this artwork')
                    $('#more_infos').fadeOut(3000)
                    $("#btninfo").removeClass("hide")
                    $("#btninfo").addClass("show")
                }
            })
        })
   </script>
   <script type="text/javascript" src='valutations.js'></script>
</html>