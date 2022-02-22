<?php session_start()
?>
<?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
    or die ('Could not connect: ' .pg_last_error());

    $newUsername = $_POST['username'];
    $newCategory = $_POST['category'];
    $email = $_POST['email'];
    $q = "update utente set categoria = $1, username = $2 where email = $3";
    $result = pg_query_params($dbconn, $q, array($newCategory, $newUsername, $email));
    if(!($result)){
        echo "<script> window.alert('An error occured! Try again')</script>";
        echo "<script> location.href='editAccount.php'</script>";
    }
    else {
        echo "<script> window.alert('Changes successfully saved') </script>";
        echo "<script> location.href='../WelcomeHomepage/welcomeHomepage.html' </script>";
    }
?>