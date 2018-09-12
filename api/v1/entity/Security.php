<?php
    require_once("Token.php");
    require_once("../common/Response.php");

    checkTokenUser();

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

    function checkTokenUser()
    {        
        try{
            Token::decodeForUser(getHeaders("access_token"));
        }catch(Exception $e){
            $response = new Response();
            $response->ErrorMessage(-1001, "Invalid User Token");
            Ok($response);
            exit();
        }
    }

    function GetTokenUser()
    {        
        try{
            return Token::decodeForUser(getHeaders("access_token"));
        }catch(Exception $e){
            throw $e->getMessage();
        }
    }

?>