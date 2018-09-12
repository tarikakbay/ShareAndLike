<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization");

    //include database and object files
    require_once("../infrastructure/Db.php");
    require_once("../libraries/Response.php");
    require_once("../entity/Security.php");
    require_once("../entity/User.php");
    require_once("../entity/Token.php");
    require_once("../entity/Security.php");

    //instantiate object
    $db = new Db();
    $response = new Response();
    $user = new User($db);

    try {

        //variable setting
        $deviceKey = $db->escape_string($_GET['deviceKey']); 

        $userId = $user->GetUserId($db->escape_string(GetTokenUser()->usermail));
        $deviceId = $user->GetDeviceIdForUser(GetTokenUser()->usermail, $deviceKey);
 
        //display success message
        if($userId>0 && $deviceId>0)
        {
            $data=array("device_token"=>Token::encodeForDevice(GetTokenUser()->usermail, $deviceKey),
                        "expires_in"=>3600,
                        "deviceKey"=>$deviceKey);//exprise day

            $response->SuccessMessageWithCode(1,"Başarılı" , $data); 
        }
        else {
            $response->ErrorMessage(-1,"Nesne Bulunamadı"); 
        }

        // echoing JSON response
        Ok($response);

    } catch (Exception $e) {
        $response->ErrorMessage(-999,"unexpected error".$e->getMessage()."\n"); 
        Ok($response);
    }
?>