<?php
    $location = '../Infos/';
    $artwork = $_POST['art'];
    $extension = '.txt';
    $filename = $location.$artwork.$extension;

    $infosFile = fopen($filename, "r") or die("Unable to open infos file");
    echo fread($infosFile,filesize($filename));

    fclose($infosFile);
?>