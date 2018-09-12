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
    require_once("../entity/DeviceData2Send.php");
    require_once("../entity/Security.php");
    require_once("../entity/User.php");

    //instantiate object
    $db = new Db();
    $response = new Response();
    $user = new User($db);
    $deviceData2Send = new DeviceData2Send($db);


    try {
        //variable setting
        $reportName = $db->escape_string($_GET['reportName']);
        $startIndex = $db->escape_string($_GET['startIndex']);
        $pageCount = $db->escape_string($_GET['pageCount']);
        //object set 
        $result = ""; $rowCount=0;
        $filter["reportName"] = $reportName; 

        if($reportName == "DataSendByDeviceKey")
        { 
            $deviceKey = $db->escape_string($_GET['deviceKey']);

            $filter["deviceKey"] = $deviceKey;
            $deviceId = $user->GetDeviceIdForUser(GetTokenUser()->usermail, $deviceKey);

            if($deviceId>0)
            {
                $result   = $deviceData2Send->GetPaged($filter, $startIndex, $pageCount);
                $rowCount = $deviceData2Send->GetRowCount($filter);
            }
        }
 
        $response->SuccessMessagePager($result,$rowCount);
        
        // echoing JSON response
        Ok($response);

    } catch (Exception $e) {
       $response->ErrorMessage(-999,"unexpected error".$e->getMessage()."\n"); 
       Ok($response);
    }
?>