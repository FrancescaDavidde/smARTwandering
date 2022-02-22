<?php session_start();

    $currentUser = $_SESSION['current_user'];
    $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
    or die ('Could not connect: ' .pg_last_error());

    $q = "delete from utente where email=$1";
    $result = pg_query_params($dbconn, $q, array($currentUser));
    if(!($result)){
        echo "<script> window.alert('An error occured! Try again')</script>";
        echo "<script> location.href='editAccount.php'</script>";
    }
    else{
        $_SESSION = array();
        session_unset(); 
        session_destroy();
        echo "<script> window.alert('Changes successfully saved') </script>";
        echo "<script> location.href='../Homepage/homepage.html' </script>";
    }
?>
