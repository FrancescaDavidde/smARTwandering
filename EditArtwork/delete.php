<!-- script php eliminazione dal db -->
<?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
    or die ('Could not connect: ' .pg_last_error());
    $name = $_GET['name'];
    $author = $_GET['author'];
    $q = "delete from opera where nome='$name' and autore='$author'";
    $result = pg_query($dbconn, $q);
    if(!($result)){
        echo "<script> window.alert('An error occured! Try again')</script>";
        echo "<script> location.href='editArtwork.php?name=$urlname&author=$urlauthor'</script>";
    }
    else{
        echo "<script> window.alert('$name by $author has been successfully deleted! 👌');</script>";
        echo "<script> location.href='../WelcomeHomepage/welcomeHomepage.html' </script>";
    }
?>