<?php 
include_once '../infrastructure/JWToken.php';
include_once '../MainConfig.php';

class Token {

    // object properties
    static $secretKey="35^&@ta1y*562!wzJGH!22";
    static $TokenExpHourUser= 8640; //1 yıl saat;
    static $TokenExpHourDevice = 86400; //10 yıl;

    //User
    public static function encodeForUser($userMail)
    {
        $payload = array(
            'iss'      => MainConfig::$tokenIss,
            'exp' 	   => time()+(self::$TokenExpHourUser * 60 * 60), //saat to saniye
            'usermail' => $userMail,
            'role'     => 1
        );
 
        return JWToken::encode($payload, self::$secretKey,'HS512');
    }
    public static function decodeForUser($token)
    { 
        $data = JWToken::decode($token,self::$secretKey,'HS512');
        
        if($data->iss != MainConfig::$tokenIss)
        {
            throw new Exception("Unsupported or invalid token iss for user");
        }
        else if ($data->exp < time())
        {
            throw new Exception("Token is expired date");
        }
        else
        {
            return $data;
        }
    }
}
?>