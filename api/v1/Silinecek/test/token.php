<?php 
    require_once("../entity/Token.php");
    sifrele();

function sifrele()
{
    $token = Token::encodeForUser("tarikakbay@gmail.com");

    try{
        $cozulmus = Token::decodeForUser($token);
        echo $cozulmus->usermail; 
        
    }catch(Exception $e){
        echo $e->getMessage();
    }
}


?>