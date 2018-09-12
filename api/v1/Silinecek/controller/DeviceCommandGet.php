<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, access_token");

    //include database and object files
    require_once("../infrastructure/Db.php");
    require_once("../libraries/Response.php");
    require_once("../entity/Security.php");
    require_once("../entity/DeviceCommand.php");
    require_once("../entity/User.php");

    //instantiate object
    $db = new Db();
    $response = new Response();
    $user = new User($db);
    $deviceCommand = new DeviceCommand($db);

    try {
        //variable setting
        $reportName = $db->escape_string($_GET['reportName']);

        //object set 
        $result = "";
        $filter["reportName"] = $reportName; 

        if($reportName == "CommandByDeviceKey")
        {
            $deviceKey = $db->escape_string($_GET['deviceKey']);
            
            //Kullanıcıya ait device kontrolü yapılıyor
            $deviceId = $user->GetDeviceIdForUser(GetTokenUser()->usermail, $deviceKey);
            $filter["deviceId"] = $deviceId; 
             
            if($deviceId>0)
            {
                $result = $deviceCommand->Get($filter);
            } 
        } 
 
        $response->SuccessMessage($result);
          
        // echoing JSON response
        Ok($response);

    } catch (Exception $e) {
        $response->ErrorMessage(-999,"unexpected error".$e->getMessage()."\n"); 
        Ok($response);
    }
?>