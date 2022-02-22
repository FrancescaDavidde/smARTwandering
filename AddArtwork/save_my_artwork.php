<?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
              or die("Could not connect: " .pg_last_error());
    
    $user_is_admin = 0;

    $name = $_POST['name'];
    $author = $_POST['author'];
    $category = $_POST['category'];

    //timePeriod è il primo campo in più dell'admin rispetto allo user-->se lo visualizzo è perchè sono admin
    if(isset($_POST['timePeriod'])) { 
        $user_is_admin = 1;

        $timePeriod = $_POST['timePeriod'];
        $dimensions = $_POST['dimensions'];
        $vote = $_POST['vote'];
        $valutations = $_POST['valutations'];
        $location = $_POST['location'];
        $imm1 = $_POST['imm1'];
        $imm2 = $_POST['imm2'];
        $imm3 = $_POST['imm3'];
        $imm4 = $_POST['imm4'];
        $imm5 = $_POST['imm5'];
        $lat = $_POST['lat'];
        $long = $_POST['long'];
    }

    //opera già presente nel db
    $already_there = 'select * from opera where nome=$1 and autore=$2'; 
    if (pg_fetch_array(pg_query_params($dbconn, $already_there, array($name,$author)), null , PGSQL_ASSOC)) {
        echo json_encode([
            "status" => 400 ,
            "message" => "Artwork already present"
            ]);
        return;
    }

    //opera non presente nel db-->la aggiungo
    if ($user_is_admin) {
        $admin_update = 'insert into opera values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15)';
        $result = pg_query_params($dbconn, $admin_update, array($vote,$valutations,$timePeriod,
                                                                $name,$location,$imm5,
                                                                $imm4,$imm3,$imm2,
                                                                $imm1,$author,$dimensions,
                                                                $category,$lat,$long));
    } else {
        $user_update = 'insert into opera values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15)';
        $result = pg_query_params($dbconn, $user_update, array(null, null, null, 
                                                               $name, null, null, 
                                                               null, null, null, 
                                                               null, $author, null, 
                                                               $category, null, null));
    }

    if ($result) {
        echo json_encode([
            "status" => 200 ,
            "message" => "The artwork was correctly inserted into the system 😃"
        ]);
    } else {
        echo json_encode([
            "status" => 500 ,
            "message"=> "Internal server error"
        ]);
    }
?>