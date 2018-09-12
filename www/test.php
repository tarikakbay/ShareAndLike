<?php
    require_once("_header.php");
    require_once("_nav.php");
    require_once("_menu.php");

    $data = array("email"=>"tarik","password"=>"12345");
    echo CallAPI("POST","http://www.tarikakbay.com/iot/api/v1/controller/UserLoginPost.php",$data);
?>