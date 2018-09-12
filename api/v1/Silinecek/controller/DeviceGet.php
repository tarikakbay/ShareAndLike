<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");

    //include database and object files
    require_once("../infrastructure/Db.php");
    require_once("../libraries/Response.php");
    require_once("../entity/Security.php");
    require_once("../entity/Device.php");
    require_once("../entity/User.php");

    //instantiate object
    $db = new Db();
    $response = new Response();
    $user = new User($db);
    $device = new Device($db);

    try {
        //variable setting
        $reportName = $db->escape_string($_GET['reportName']);

        //object set 
        $result = "";
        $filter["reportName"] = $reportName; 

        if($reportName == "UserDevices")
        { 
            $filter["userId"] = $user->GetUserId($db->escape_string(GetTokenUser()->usermail));

            $result = $device->Get($filter);
        }
        else if($reportName == "DeviceAll")
        {

        }
 
        $response->SuccessMessage($result);
          
        // echoing JSON response
        Ok($response);

    } catch (Exception $e) {
        $response->ErrorMessage(-999,"unexpected error".$e->getMessage()."\n"); 
        Ok($response);
    }
?>