<?php
    require_once("../infrastructure/Cryptography.php");
    $sifre = new Cryptography();

    $metin = "testYazi";
    $sifreliMetin = $sifre -> Decode($metin);
    $cozulmusMetin = $sifre-> Encode ($sifreliMetin);

    echo "Metin: ".$metin."<br/>";
    echo "sifreli Metin: ".$sifreliMetin."<br/>";
    echo "cozulmus Metin: ".$cozulmusMetin."<br/>";
?>