<?php
// önek yok.
// Sadece PHP 5 ve sonraki sürümlerde çalışır
$uni=uniqid();
echo "uniqid: " . $uni."<br>";

$token = md5($uni);
echo "Token: " . $token."<br>";

// daha iyisi; tahmini güçleştirelim
$better_token = md5(uniqid(mt_rand(), true));
echo "better_token: " . $better_token."<br>";

?>