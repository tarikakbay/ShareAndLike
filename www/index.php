<?php
    $page = stripslashes(trim($_GET['p']));
    $token = $_COOKIE['access_token'];
    $fileName = '';

    if(!$token)
    {//Token Yok
        $page = "login";
    }

    switch($page)
    {
        default:
            header('HTTP/1.0 404 Not Found');
            require '404.html';
            break;
        case "login":
            $fileName = 'login.php';
            break;
        case "logout":
            $fileName = logout();
            break;
        case "dashboard":
            $fileName = 'dashboard.php';
            break;
        case "share":
            $fileName = 'share.php';
        break; 
        case "register":
            $fileName = 'register.php';
        break; 
        case "settings":
            $fileName = 'settings.php';
        break; 
    }
    
    require $fileName; 


    function logout()
    {
        setcookie("access_token", "", time() - 3600);
        setcookie("userName", "", time() - 3600);
        return 'login.php'; 
    }
?>