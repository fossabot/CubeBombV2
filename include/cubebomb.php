<?php

date_default_timezone_set("Etc/Universal");

include ($_SERVER["DOCUMENT_ROOT"] . "/include/timeago.inc.php");


$isLoggedIn = false;
//$user = array();

if (isset($_COOKIE["login"])){
    $cookie = escape(trim($_COOKIE["login"]));
    
    if (strlen($cookie) == 32 && isset($_COOKIE["login"])){
        if (checkCookie()){
            $isLoggedIn = true;
            
            $user = getArray("SELECT * FROM  `private_users` WHERE  `cookie` ='" . $cookie . "' LIMIT 0 , 1");
            
        }else{
            // Bad cookie -- reset it
            cookie("login", "", 0);
        }
    }else{
        // Bad cookie -- reset it
        cookie("login", "", 0);
    }
}

// Returns whether or not the cookie is valid
function checkCookie(){
    global $cookie;
    
    if (getSingleValue("SELECT count(`id`) FROM  `private_users` WHERE  `cookie` ='" . $cookie . "' LIMIT 0 , 1") != 1){
        return false;
    }else{
        return true;
    }
}
            
function cookie($name, $value, $time){
    setCookie($name, $value, $time, "/", "www.cubebomb.com");
}
?>