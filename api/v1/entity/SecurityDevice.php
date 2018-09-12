<?php
    require_once("Token.php");
    require_once("../common/Response.php");
    checkTokenDevice();

    function getHeaders($header_name=null)
    {
        $keys=array_keys($_SERVER);
    
        if(is_null($header_name)) {
                $headers=preg_grep("/^HTTP_(.*)/si", $keys);
        } else {
                $header_name_safe=str_replace("-", "_", strtoupper(preg_quote($header_name)));
                $headers=preg_grep("/^HTTP_${header_name_safe}$/si", $keys);
        }
    
        foreach($headers as $header) {
                if(is_null($header_name)){
                        $headervals[substr($header, 5)]=$_SERVER[$header];
                } else {
                        return $_SERVER[$header];
                }
        }
    
        //var_dump($headervals);
        return $headervals;
    }

    function checkTokenDevice()
    {        
        try{
            Token::decodeForDevice(getHeaders("device_token"));
        }catch(Exception $e){
            $response = new Response();
            $response->ErrorMessage(-1001, "Invalid Device Token");
            Ok($response);
            exit();
        }
    }

    function GetTokenDevice()
    {        
        try{
            return Token::decodeForDevice(getHeaders("device_token"));
        }catch(Exception $e){
            throw $e->getMessage();
        }
    }

    function GetRequestContent()
    {
        //Receive the RAW post data.
        $requestContent = trim(file_get_contents("php://input"));
        //Attempt to decode the incoming RAW post data from JSON.
        $requestDecoded = json_decode($requestContent, true);
        //If json_decode failed, the JSON is invalid.
        if(!is_array($requestDecoded)){
            throw new Exception('Received content contained invalid JSON!');
        }

        return $requestDecoded;
    }

?>