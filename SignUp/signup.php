<?php
    session_start();
?>

<html>
    <head></head>
    <body>
        <?php
            $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
            or die('Could not connect:' .pg_last_error());
            if(!(isset($_POST['signupButton']))){
                header("Location: ../Homepage/homepage.html");
            }
            else {
                $email= $_POST['e-mail'];
                $q1 = "select * from utente where email= $1";
                $result = pg_query_params($dbconn, $q1, array($email));
                if($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
                    echo "<script> window.alert('You are already registered')</script>";
                    echo "<script> location.href='../Login/login.html'</script>";
                }
                else {
                    $name = $_POST['name'];
                    $surname = $_POST['surname'];
                    $username = $_POST['username'];
                    $password = md5($_POST['password']);
                    $category = $_POST['category'];
                    $q2 = "insert into utente values ($1,$2,$3,$4,$5,$6,$7)";
                    $data = pg_query_params($dbconn, $q2, array($category, $surname, $email, $name, $password, $username, 0));
                    if($data){
                        $_SESSION['current_user'] = $email;
                        $_SESSION['user_password'] = $password;
                        echo "<script>location.href='../WelcomeHomepage/welcomeHomepage.html'</script>";
                    }
                }
            }
        ?>
    </body>
</html>

        