<!-- script che precede l'eliminazione -->
<?php 
    $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
    or die ('Could not connect: ' .pg_last_error());
    $name = $_GET['name'];
    $author = $_GET['author']; 
    $urlname = urlencode($name);
    $urlauthor = urlencode($author); 
    echo "<script> var domanda = window.confirm('Are you sure you want to delete this artwork? ❌'); 
           if(domanda === true) {
               location.href='delete.php?name=$urlname&author=$urlauthor';
            }
            else {
                location.href='editArtwork.php?name=$urlname&author=$urlauthor';
            } </script>";
?>