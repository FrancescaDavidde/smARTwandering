<?php
require_once('PHPMailer/PHPMailerAutoload.php');

    // funzione per generare una stringa randomica
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $specials = '@#_!?^=£$%&/()*-.,;:';
        $numbers = '123456789';

        $charactersLength = strlen($characters);
        $specialsLength = strlen($specials);
        $numbersLength = strlen($numbers);

        $randomString = '';
        for ($i = 0; $i < $length-2; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $randomString .= $specials[rand(0, $specialsLength - 1 )];
        $randomString .= $numbers[rand(0, $numbersLength - 1 )];
        return $randomString;
    }

    // recupero i parametri passati con ajax
    $user = $_POST['utente'];
    $exist = 1; 

    // connessione ad bd
    $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password")
              or die ('Could not connect: ' .pg_last_error());
    
    // cerco un utente con la data email
    $query_user = 'select nome from utente where email = $1';
    if (!pg_fetch_array(pg_query_params($dbconn,$query_user,array($user)), null , PGSQL_ASSOC))
        $exist = 0;

    // setto il body dell'email correttamente a seconda di due possibili casi
    $new_psw = generateRandomString();
    if ($exist) {
        $body = 'Hello! You have requested a new password: if it is not you please contact us using the section "Contact us".
        This is your new password : ' .$new_psw;
    } else {
        $body = 'No user is registered with this email. Try insert you email again';
    }

    // aggiorno la psw nel bd
    if ($exist) {
        $password = md5($new_psw);
        $query_update = 'update utente set password = $1 where email = $2';
        $result = pg_query_params($dbconn, $query_update, array($password, $user));
        if(!($result))
            echo json_encode(["status" => 500,"message" => "Internal server error"]);
    }

    // imposto i parametri nell'email e la invio
    $email = new PHPMailer();
    $email->isSMTP();
    $email->SMTPAuth = true;
    $email->SMTPSecure = 'ssl';
    $email->Host = 'smtp.gmail.com';
    $email->Port = '465';
    $email->isHTML();
    $email->Username = 'smartwanderingcustomer@gmail.com';
    $email->Password = 'ApolloeDafne!';
    $email->Subject = 'Password recovery';
    $email->FromName = "SmartWandering";
    $email->AddAddress($user);
    $email->Body = $body;
    $email->Send();
?>