<?php
    try
    {
        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
 
        // //include database and object files
        require_once("../infrastructure/Db.php");
        require_once("../libraries/Response.php"); 
        require_once("../entity/SecurityDevice.php"); 
        require_once("../entity/User.php");
        require_once("../entity/DeviceLog.php"); 
        require_once("../entity/DeviceLogDetail.php"); 
        require_once("../entity/DeviceData2Send.php");
        
        //instantiate object
        $db = new Db();
        $response = new Response();
        $user = new User($db);
        $deviceLog = new DeviceLog($db);
        $deviceLogDetail = new DeviceLogDetail($db);
        $deviceData2Send = new DeviceData2Send($db);

        //variable setting
        $deviceKey        = GetTokenDevice()->deviceKey;
        $userMail         = GetTokenDevice()->usermail; 
        $requestContent   = GetRequestContent();
        $requestIpAddress = $_SERVER['REMOTE_ADDR'];

        //deviceKey ve UserMail geçerli mi kontrole ediliyor
        $deviceId = $user->GetDeviceIdForUser($userMail, $deviceKey); 
        if($deviceId > 0)
        {
            //Request için ana bilgiler kaydı
            $deviceLog->DeviceKey        = $deviceKey;
            $deviceLog->DeviceId         = $deviceId;
            $deviceLog->RequestIpAddress = $requestIpAddress;
            $deviceLog->RequestData      = $requestContent;
            $deviceLog->ResponseData     = "";
            $recordState = $deviceLog->Create();

            //Request için detay bilgiler kaydı
            if($recordState)
            {
                if($requestContent["Logs"] != null)
                 {
                    $deviceLogDetail->DeviceLogId = $deviceLog->Id;
                    $deviceLogDetail->DataType = 0; //0:request,1:Response

                    foreach($requestContent["Logs"] as $row) {
                        $deviceLogDetail-> DataKey   = $row["Key"];
                        $deviceLogDetail-> DataValue = $row["Value"];

                        $deviceLogDetail->Create();
                    }
                }
            }

            //Response için ana bilgi işlemleri

            //Gönderilecek komutlar Okunuyor
            $filter["reportName"] = "NotSendDataByDeviceKey";
            $filter["deviceKey"] = $deviceKey;
            $sendableData = $deviceData2Send -> Get($filter); //çekilen datalar update edilmiş
            
            //Ana bilgide Response update et
            $response ->SuccessMessage($sendableData);
            $deviceLog->ResponseData = json_encode($response);
            $deviceLogDetail->Update();
                
            //json Çıktı ver 
            echo $deviceLog->ResponseData;

            //Ana bilgiye ait detay ekle
            $deviceLogDetail->DeviceLogId = $deviceLog->Id;
            $deviceLogDetail->DataType = 1; //0:request,1:Response

            foreach($sendableData as $row) {
                $deviceLogDetail-> DataKey   = $row["DataKey"];
                $deviceLogDetail-> DataValue = $row["DataValue"];

                $deviceLogDetail->Create();
            }
        } 
    }
    catch(Exception $e)
    {
        $response->ErrorMessage(-999,"unexpected error".$e->getMessage()."\n"); 
        Ok($response);
    }
?>