<?php

date_default_timezone_set("Etc/Universal");

include_once($_SERVER["DOCUMENT_ROOT"] . "/include/timeago.inc.php");
include_once("/var/www/secure/db.php");

$isLoggedIn = false;
$userId = 0;
//$user = array();

// Simple global variables
$_PNONE   = 0;
$_PARTIST = 1;
$_PMOD    = 2;
$_PADMIN  = 3;
$_POP     = 4;

if (isset($_COOKIE["login"])){
    $cookie = escape(trim($_COOKIE["login"]));
    
    if (strlen($cookie) == 32 && isset($_COOKIE["login"])){
        if (checkCookie()){
            $isLoggedIn = true;
            
            $user = getArray("SELECT * FROM `private_users` WHERE  `cookie` ='" . $cookie . "' LIMIT 0 , 1");
            
            $userId = $user["id"];
            
            $user += getArray("SELECT * FROM (SELECT COUNT(`id`) AS `messages` FROM `private_messages` WHERE `receiverId` ='$userId' AND `seen` =0 AND `deleted` =0) A,
                                             (SELECT `permissions` FROM `private_users` WHERE `id` ='$userId' LIMIT 0, 1) B");
            
            // Update last visit time
            query("UPDATE `private_users` SET `lastTime` = now() WHERE `id` = '$userId';");
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