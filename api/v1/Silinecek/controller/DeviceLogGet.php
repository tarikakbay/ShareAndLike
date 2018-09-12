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
    require_once("../entity/User.php");
    require_once("../entity/DeviceLogDetail.php");
    require_once("../entity/Security.php");

    //instantiate object
    $db = new Db();
    $response = new Response();
    $user = new User($db);
    $deviceLogDetail = new DeviceLogDetail($db);

    try {
        //variable setting
        $reportName = $db->escape_string($_GET['reportName']);
        $startIndex = $db->escape_string($_GET['startIndex']);
        $pageCount = $db->escape_string($_GET['pageCount']);
        //object set 
        $result = ""; $rowCount=0;
        $filter["reportName"] = $reportName; 

        if($reportName == "LogRequestByDeviceKey")
        { 
            $deviceKey = $db->escape_string($_GET['deviceKey']);

            $filter["deviceKey"] = $deviceKey;
            $deviceId = $user->GetDeviceIdForUser(GetTokenUser()->usermail, $deviceKey);

            if($deviceId>0)
            {
                $result   = $deviceLogDetail->GetPaged($filter, $startIndex, $pageCount);
                $rowCount = $deviceLogDetail->GetRowCount($filter);
            }
        }
        else if($reportName == "LogResponseByDeviceKey")
        { 
            $deviceKey = $db->escape_string($_GET['deviceKey']);

            $filter["deviceKey"] = $deviceKey;
            $deviceId = $user->GetDeviceIdForUser(GetTokenUser()->usermail, $deviceKey);

            if($deviceId>0)
            {
                $result   = $deviceLogDetail->GetPaged($filter, $startIndex, $pageCount);
                $rowCount = $deviceLogDetail->GetRowCount($filter);
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