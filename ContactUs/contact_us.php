<?php
require_once('PHPMailer/PHPMailerAutoload.php');
    //creo istanza PHP mailer e setto i parametri
    $email = new PHPMailer();
    $email->isSMTP();
    $email->SMTPAuth = true;
    $email->SMTPSecure = 'ssl';
    $email->Host = 'smtp.gmail.com';
    $email->Port = '465';
    $email->isHTML();
    $email->Username = 'smartwanderingcustomer@gmail.com';
    $email->Password = 'ApolloeDafne!';
    $email->Subject = 'User email';
    $email->FromName = "Support Team";
    $email->AddAddress('smartwanderinginrome@gmail.com');
    
    if (isset($_POST['text'])) {
        $body = $_POST['text'];
        $email->Body = $body;
        $email->Send();

        echo json_encode([
            "status" => 200,
            "message" => "Your email has been sent: thank you for contacting us!"
        ]);
    }
    else {
        echo json_encode([
            "status" => 500,
            "message" => "Something went wrong: please retry later"
          ]);
    }
?>