<?php session_start();
?>
<html>
    <head></head>
    <body>
        <?php 
            $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
            or die ('Could not connect: ' .pg_last_error());
            if(!(isset($_POST['loginButton']))){
                header("Location ../Homepage/homepage.html");
            }
            else {
                $email = $_POST['e-mail'];
                $q1 = "select * from utente where email = $1";
                $result = pg_query_params($dbconn, $q1, array($email));
                if(!($line = pg_fetch_array($result, null, PGSQL_ASSOC))){
                    echo "<script> window.alert('You are not registered! Click OK to sign up!');</script>";
                    echo "<script> location.href='../SignUp/signup.html' </script>";
                }
                else {
                    $password = md5($_POST['password']);
                    $q2 = "select * from utente where email = $1 and password = $2";
                    $result = pg_query_params($dbconn, $q2, array($email, $password));
                    if(!($line = pg_fetch_array($result, null, PGSQL_ASSOC))){
                        echo "<script> window.alert('Invalid email or password! Click OK to try again!');</script>";
                        echo "<script> location.href='login.html' </script>";
                    }
                    else {
                        $_SESSION['current_user'] = $email;
                        $_SESSION['user_password'] = $password;
                        echo "<script>location.href='../WelcomeHomepage/welcomeHomepage.html'</script>";
                    }
                }
            }