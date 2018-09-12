<?php
    require_once("_header.php");
    require_once("_nav.php");
    require_once("_menu.php");
    require_once("_footer.php"); 
    echo "burada44";

    setcookie("access_token", "", time() - 3600);
    setcookie("userName", "", time() - 3600);
    echo "burada0";
    header("Location: index.php?page=login");
    echo "burada1";
?>