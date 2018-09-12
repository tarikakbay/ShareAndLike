<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, access_token");

    //include database and object files
    require_once("../infrastructure/Db.php");
    require_once("../libraries/Response.php");
    require_once("../entity/DeviceData2Send.php");
    require_once("../entity/Security.php");
    require_once("../entity/User.php");

    //instantiate object
    $db = new Db();
    $response = new Response();
    $user = new User($db);
    $deviceData2Send = new DeviceData2Send($db);

    try {
        $deviceKey = $db->escape_string($_POST['deviceKey']);
        $commandIdIncoming = $db->escape_string($_POST['commandId']);

        $userId = $user->GetUserId($db->escape_string(GetTokenUser()->usermail));
        $deviceId = $user->GetDeviceIdForUser(GetTokenUser()->usermail, $deviceKey); 
        $commandId = $user->GetCommandIdForUser(GetTokenUser()->usermail, $deviceKey, $commandIdIncoming);

        if($userId > 0 && $deviceId > 0 && $commandId > 0)
        {
            $date = time();
            $startDatetime = date('Y-m-d H:i:s', $date);
            $finishDatetime = date('Y-m-d H:i:s', strtotime('+1 day',  $date)); 

            //object set
            $deviceData2Send->DeviceId        = $deviceId;
            $deviceData2Send->DeviceKey       = $deviceKey;
            $deviceData2Send->DeviceCommandId = $commandId;
            $deviceData2Send->StartDatetime   = $startDatetime;
            $deviceData2Send->FinishDatetime  = $finishDatetime; 
            $deviceData2Send->RequestCount    = 0;
            $deviceData2Send->DataState       = 0; //0:Gönderilmeyi Bekliyor,1:Gönderildi, 2:Zaman Aşımı
            $deviceData2Send->RecordUserId    = $userId;
            
            $result = $deviceData2Send->Create(); 
        }

        //display success message
        if($result)
        {
            $response->SuccessMessageWithCode(1,"Command added successfully", $deviceData2Send); 
        }
        else {
            $response->ErrorMessage(-1,"Command not added"); 
        }

        // echoing JSON response
        Ok($response);

    } catch (Exception $e) {
        $response->ErrorMessage(-999,"unexpected error".$e->getMessage()."\n"); 
        Ok($response);
    }
?>