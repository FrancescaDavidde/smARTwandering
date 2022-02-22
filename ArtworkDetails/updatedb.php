<?php
    // ricarico i parametri:
    $artwork = $_POST['artwork'];
    $mark =    $_POST['mark'];

    // connessione con il db
    $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password") 
              or die("Could not connect to postgres: " .preg_last_error());

    // prendo il voto:
    $queryVote = 'SELECT voto FROM opera WHERE nome=$1';
    $resultVote = pg_query_params($dbconn, $queryVote, array($artwork));
    $vt = pg_fetch_array($resultVote, null , PGSQL_ASSOC);
    $vote = ((int)$vt['voto']);

    // prendo le valutazioni:
    $queryValutation = 'SELECT valutazioni FROM opera WHERE nome=$1';
    $resultValutation = pg_query_params($dbconn, $queryValutation, array($artwork));
    $val = pg_fetch_array($resultValutation, null , PGSQL_ASSOC);
    $valutation = ((int)$val['valutazioni']);

    // calcolo il valore aggiornato delle colonne:
    $to_add_valutation = $valutation + 1;
    $to_add_mark = ceil(($vote + $mark)/2);     // (5 + 3)/2 = 4
    
    $updateQuery = 'UPDATE opera SET valutazioni = $1 , voto = $2 WHERE nome = $3';
    $result = pg_query_params($dbconn, $updateQuery, array($to_add_valutation, $to_add_mark , $artwork));
?>