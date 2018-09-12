<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include database and object files
    require_once("../infrastructure/Db.php");
    require_once("../common/Response.php");
    require_once("../entity/User.php");
    require_once("../common/Validation.php");

    //instantiate object
    $db = new Db();
    $response = new Response();
    $valid = new Validation();
    $user = new User($db);

    try {

        //variable setting
        $userName         = $db->escape_string($_POST['name']);
        $userSurname      = $db->escape_string($_POST['surname']); 
        $userUserName     = $db->escape_string($_POST['username']); 
        $userEmail        = $db->escape_string($_POST['email']); 
        $userPassword     = $db->escape_string($_POST['password']); 
        $userPasswordMd5  = md5($userPassword);

        $resultEmail = $user->CheckIsEmail($userEmail);
        $resultUserName = $user->CheckIsUserName($userUserName);
        
        $isValidEntity = true;

        if($valid->isNullOrEmptyString($userName))
        {
            $isValidEntity = false;
            $response->ErrorMessage(-1,"Kullanıcı ismi Boş Olamaz"); 
        }

        if($valid->isNullOrEmptyString($userSurname))
        {
            $isValidEntity = false;
            $response->ErrorMessage(-2,"Kullanıcı Soyismi Boş Olamaz"); 
        }

        if($valid->isNullOrEmptyString($userUserName))
        {
            $isValidEntity = false;
            $response->ErrorMessage(-3,"Kullanıcı Adı Boş Olamaz"); 
        }

        if($valid->isNullOrEmptyString($userEmail))
        {
            $isValidEntity = false;
            $response->ErrorMessage(-4,"E-Posta Boş Olamaz"); 
        }

        if($valid->isNullOrEmptyString($userPassword))
        {
            $isValidEntity = false;
            $response->ErrorMessage(-5,"Şifre Boş Olamaz"); 
        }

        if($resultEmail)
        {
            $isValidEntity = false;
            $response->ErrorMessage(-6,"Kayıtlı E-Posta Adresi"); 
        }

        if ($resultUserName)
        {
            $isValidEntity = false;
            $response->ErrorMessage(-7,"Kayıtlı Kullanıcı Adı"); 
        }
        
        if($isValidEntity)
        {
            $user->Name      = $userName;
            $user->Surname   = $userSurname;
            $user->UserName  = $userUserName;
            $user->Email     = $userEmail;
            $user->Password  = $userPasswordMd5;
            $user->UserState = 1;
            $user->UserType  = 1;

            $result = $user->Create();

            //display success message
            if($result)
            {
                $response->SuccessMessageWithCode(1,"Başarılıyla Kayıt Edildi", $result); 
            }
            else {
                $response->ErrorMessage(-99,"Başarısız Kayıt Ekleme!"); 
            }
        }

        // echoing JSON response
        Ok($response);

    } catch (Exception $e) {
        $response->ErrorMessage(-999,"Beklenilmeyen Hata Oluştu!".$e->getMessage()."\n"); 
        Ok($response);
    }
?>