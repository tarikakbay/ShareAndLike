<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization");

    //include database and object files
    require_once("../infrastructure/Db.php");
    require_once("../common/Response.php");
    require_once("../entity/User.php");
    require_once("../entity/Token.php");

    //instantiate object
    $db = new Db();
    $response = new Response();
    $user = new User($db);

    try {

        //variable setting
        $userEmail        = $db->escape_string($_POST['email']);
        $userPassword     = $db->escape_string($_POST['password']); 
        $userPasswordMd5  = md5($userPassword);
 
        $result = $user->CheckUser($userEmail,$userPasswordMd5);

        //display success message
        if($result)
        {
            $data=array("access_token"=>Token::encodeForUser($user->Email),
                        "expires_in"=>3600,
                        "userName"=>$user->Name);//exprise day

            $response->SuccessMessageWithCode(1,"Welcome: ".$user->Name , $data); 
        }
        else {
            $response->ErrorMessage(-1,"Kullanıcı Bulunamadı"); 
        }

        // echoing JSON response
        Ok($response);

    } catch (Exception $e) {
        $response->ErrorMessage(-999,"unexpected error".$e->getMessage()."\n"); 
        Ok($response);
    }
?>