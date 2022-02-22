<?php session_start();

    $currentUser = $_SESSION['current_user'];
    $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
    or die ('Could not connect: ' .pg_last_error());

    echo "<script> var domanda = window.confirm('Are you sure you want to delete your account?'); 
           if(domanda === true) {
               location.href='delete.php';
            }
            else {
                location.href='editAccount.php';
            } </script>";
?>