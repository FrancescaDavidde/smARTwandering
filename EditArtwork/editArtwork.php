<?php
    session_start();
?>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <script type="text/javascript" lang="javascript" src="editArtwork.js"></script>

    <link rel="stylesheet" type='text/css' href="lightbox2-2.11.1/lightbox2-2.11.1/dist/css/lightbox.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    

        <?php
            $name = $_GET['name'];
            $author = $_GET['author']; 
            $dbconn = pg_connect("host=localhost port=5432
                dbname=smARTwandering user=postgres
                password=password")
            or die("Could not connect: " .pg_last_error());
            $q1 = 'SELECT * FROM opera WHERE nome=$1 AND autore=$2';
            $result = pg_query_params($dbconn, $q1,
                array($name, $author));
            $infos = pg_fetch_array($result, null, PGSQL_ASSOC);
            $timePeriod = $infos['periodo'];
            $category = $infos['categoria'];
            $place = $infos['indirizzo'];
            $foto1 = $infos['foto1'];
            $foto2 = $infos['foto2'];
            $foto3 = $infos['foto3'];
            $foto4 = $infos['foto4'];
            $foto5 = $infos['foto5'];
            $dimension = $infos['dimensioni'];
            $lat = $infos['latitudine'];
            $long = $infos['longitudine'];
        ?>

        <script> var category = <?php echo json_encode($category) ?>; </script>

    <script src='https://code.jquery.com/jquery-3.1.0.min.js'></script>
    <script type='text/javascript' src='lightbox2-2.11.1/dist/js/lightbox-plus-jquery.min.js'></script>
    <script type='text/javascript' src='details.js'></script>
    <script type="text/javascript" src='Vue/vue.min.js'></script>

    <link rel="stylesheet" href="editArtwork.css">
    <link rel="stylesheet" type='text/css' href="lightbox2-2.11.1/dist/css/lightbox.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


    <title>Edit <?php echo $name ?> </title>
    
    </head>
    <div class="tutto_container">
    <body onload="return categoriaSelezionata(category);">
    <!-- menu bar -->
    <div class="w3-bar">
            <div class="element">
                <div class ="account">Account <img src="../Images/Microsoft_Account.svg.png" width="40" height="40">       

                <div class="dropdown-content">
                    <a href="../EditAccount/editAccount.php"> Edit Account </a>
                    <a href="../EditPassword/editPassword.php"> Edit Password</a>
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
  
    

    <div class="tutto">
        <form action="saveEdit.php" method="POST" name="editArtwork">
            <div class="divText">
            <!-- carico dinamicamente i valori con lo script php -->
            <div class="nome"><?php echo $name ?> Details </div>
          
            <br>
                <label>Category</label>: <select name="category" id="category_selection">
                    <option value="star"> Star </option>
                    <option value="painting"> Painting </option>
                    <option value="architecture"> Architecture </option>
                    <option value="sculpture"> Sculpture </option>
                </select>
                <br>
                <br>
                <label>Name: </label><input type="text" name="name" value= <?php echo json_encode($name)?> readonly>
                <br>
                <br>
                <label>Author: </label><input type="text" name="author" value= <?php echo json_encode($author)?> readonly>
                <br>
                <br>
                <label>TimePeriod: </label><input type="text" name="timePeriod" value= <?php echo json_encode($timePeriod)?>>
                <br>
                <br>
                <label>Dimension: </label><input type="text" name="dimension" value= <?php echo json_encode($dimension)?>>
                <br>
                <br>
                <label>Place and Address: </label><input type="text" name="place" value= <?php echo json_encode($place)?>>
                <br>
                <br>
                <label>Latitude: </label><input type="text" name="lat" value= <?php echo json_encode($lat)?>>
                <br>
                <br>
                <label>Longitude: </label><input type="text" name="long" value= <?php echo json_encode($long)?>>
                <br>
                <br>
                <label>Image 1: </label><input type="text" name="foto1" value= <?php echo json_encode($foto1)?>>
                <br>
                <br>
                <label>Image 2: </label><input type="text" name="foto2" value= <?php echo json_encode($foto2)?>>
                <br>
                <br>
                <label>Image 3: </label><input type="text" name="foto3" value= <?php echo json_encode($foto3)?>>
                <br>
                <br>
                <label>Image 4: </label><input type="text" name="foto4" value= <?php echo json_encode($foto4)?>>
                <br>
                <br>
                <label>Image 5: </label><input type="text" name="foto5" value= <?php echo json_encode($foto5)?>>
                <br>
                <br>
                </div>
                <br>
                <div class="save"><input type="submit" value ="Save"> </div>           
           
        </form>
    <br> <br>
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
    <div class="elimina">
            <?
                $name = $_GET['name'];
                $author = $_GET['author']; 
                $urlname = urlencode($name);
                $urlauthor = urlencode($author); 
                echo "<a href='deleteArtwork.php?name=$urlname&author=$urlauthor'> <input type='button' value='Delete'> </a>";
            ?>
    </div>
    </div>
    
       
        
    <!-- footer bar -->
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
                    <a href="../ContactUs/conctact_us.html" class="footer_element">Contact Us</a>
            </div>
           
        </div>
    </body>
    </div>
   
</html>

