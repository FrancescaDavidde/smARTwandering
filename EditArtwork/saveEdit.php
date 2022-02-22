<!-- update opere nel db -->
<?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
    or die ('Could not connect: ' .pg_last_error());
    $newPeriod = $_POST['timePeriod'];
    $newCategory = $_POST['category'];
    $newPlace = $_POST['place'];
    $name = $_POST['name'];
    $author = $_POST['author'];
    $newImm1 = $_POST['foto1'];
    $newImm2 = $_POST['foto2'];
    $newImm3 = $_POST['foto3'];
    $newImm4 = $_POST['foto4'];
    $newImm5 = $_POST['foto5'];
    $newDimension = $_POST['dimension'];
    $newLat = $_POST['lat'];
    $newLong = $_POST['long'];
    $q = 'update opera set periodo = $1, categoria = $2, indirizzo = $3, foto5 = $4, foto4 = $5, foto3 = $6, foto2 = $7, foto1 = $8, dimensioni = $9, latitudine = $10, longitudine = $11 where nome = $12 and autore = $13 ';
    $result = pg_query_params($dbconn, $q, array($newPeriod, $newCategory, $newPlace, $newImm5, $newImm4, $newImm3, $newImm2, $newImm1, $newDimension, $newLat, $newLong, $name, $author));
    if(!($result)){
        echo 'Error <a href= editArtwork.php> click here </a> to try again';
    }
    else { ?>
        <script> 
        alert("..Success! 👍");
        location.replace("../WelcomeHomepage/welcomeHomepage.html"); </script> <?
                
    }
?>