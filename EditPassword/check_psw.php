<?php
    $user = $_POST['user'];
    $given_psw = md5($_POST['inserted_psw']);

    $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
              or die ('Could not connect: ' .pg_last_error());
    
    $query = 'select password from utente where email = $1 and password= $2';

    if (pg_fetch_array(pg_query_params($dbconn,$query,array($user,$given_psw)), null , PGSQL_ASSOC))
        echo json_encode(["status" => 200,"message" => "Your password has been updated"]);
    else
        echo json_encode(["status" => 400,"message" => "Wrong password, please try again"]);
?>