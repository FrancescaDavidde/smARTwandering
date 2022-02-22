<?php session_start();
?>
<?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
    or die ('Could not connect: ' .pg_last_error());

    $password = md5($_POST['newPassword']);
    $q = "update utente set password = $1 where email = $2";
    $result = pg_query_params($dbconn, $q, array($password, $_SESSION['current_user']));
    if(!($result)){
        echo "<script> window.alert('An error occured! Try again')</script>";
        echo "<script> location.href='editPassword.php'</script>";
    }
    else {
        echo "<script> window.alert('Changes successfully saved') </script>";
        echo "<script> location.href='../WelcomeHomepage/welcomeHomepage.html' </script>";
    }
?>