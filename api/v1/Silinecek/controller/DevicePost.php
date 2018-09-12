<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");

    //include database and object files
    require_once("../infrastructure/Db.php");
    require_once("../libraries/Response.php");
    require_once("../entity/Device.php");
    require_once("../entity/Security.php");

    //instantiate object
    $db = new Db();
    $response = new Response();
    $device = new Device($db);

    try {
        $userId = $user->GetUserId($db->escape_string(GetTokenUser()->usermail));

        //object set
        $device->Port = $db->escape_string($_POST['port']);
        $device->DeviceType = $db->escape_string($_POST['deviceType']);
        $device->TagName = $db->escape_string($_POST['tagName']);
        $device->AppVersion = "1.0";
        $device->RecordUserId=$userId ;
        $device->DeviceUserId=$userId ;

        $result = $device->Create(); 

        //display success message
        if($result)
        {
            $response->SuccessMessageWithCode(1,"Data added successfully", $device); 
        }
        else {
            $response->ErrorMessage(-1,"Data not added"); 
        }

        // echoing JSON response
        Ok($response);

    } catch (Exception $e) {
        $response->ErrorMessage(-999,"unexpected error".$e->getMessage()."\n"); 
        Ok($response);
    }
?>