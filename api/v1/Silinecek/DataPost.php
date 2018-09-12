<?php
    try
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: Post");
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json');
 
        //include database and object files
        require_once("../infrastructure/Db.php");
        require_once("../libraries/Response.php"); 
        require_once("../entity/Device.php"); 
        require_once("../entity/DeviceLog.php"); 

        //instantiate object
        $db = new Db();
        $response = new Response();
        $device = new Device($db);
        $deviceLog = new DeviceLog($db);

        //variable setting
        $deviceKey        = $db->escape_string($_POST['DeviceKey']);
        $incomingValue1   = $db->escape_string($_POST['Value1']);
        $incomingValue2   = $db->escape_string($_POST['Value2']);
        $incomingValue3   = $db->escape_string($_POST['Value3']);
        $requestIpAddress = $_SERVER['REMOTE_ADDR'];

        //DeviceKey kontrol edilmeli, doğru ise kayıta devam
        if(!empty($deviceKey))
        { 
            $deviceLog->DeviceKey        = $deviceKey;
            $deviceLog->IncomingValue1   = $incomingValue1;
            $deviceLog->IncomingValue2   = $incomingValue2;
            $deviceLog->IncomingValue3   = $incomingValue3;
            $deviceLog->RequestIpAddress = $_SERVER['REMOTE_ADDR'];
            $recordState = $deviceLog->Create();
  
            if($recordState )
            {
                $filter["reportName"] = "DeviceByDeviceKey";
                $filter["key"]= $deviceKey;
                $resultDevice = $device->get($filter);

                //log Kaydı alınan bilgilerle güncellenir
                //echo "kayitID:".$deviceLog->Id."<br>";
                //echo "deviceId:". $resultDevice[0]["Id"]."<br>";
                //echo "IncomingValue1:". $deviceLog->IncomingValue1 ."<br>";
                
                //response kayıt edileceğinden önceden oluşturuldu
                //Gonderilmeyi bekleyen data varsa bu aşamada gönder
                $response ->SuccessMessageNullData();

                $deviceLog->DeviceId = $resultDevice[0]["Id"];
                $deviceLog->ResponseData = json_encode($response);
                $deviceLog->Update();

                // echoing JSON response
                echo $deviceLog->ResponseData;
            }
            else
            {
                $response->ErrorMessage(-1,"Kayit islemi basarisiz"); 
                Ok($response);
            }
        }
        else
        {
            $response->ErrorMessage(-2,"Beklenilen veri bulunamadı!"); 
            Ok($response);
        }
    }
    catch(Exception $e)
    {
        $response->ErrorMessage(-999,"unexpected error".$e->getMessage()."\n"); 
        Ok($response);
    }
?>