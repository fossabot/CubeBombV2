<?php

date_default_timezone_set("Etc/Universal");

require_once($_SERVER["DOCUMENT_ROOT"] . "/include/timeago.inc.php");
require_once("/var/www/secure/db.php");

$isLoggedIn = false;
$userId = 0;
//$user = array();

// Simple global variables
// For permissions
$_PNONE   = 0;
$_PARTIST = 1;
$_PMOD    = 2;
$_PADMIN  = 3;
$_POP     = 4;

/*
// http://stackoverflow.com/questions/4762527/what-is-the-best-way-to-count-page-views-in-php-mysql
$memcache = new Memcache;
$memcache->connect("127.0.0.1") or die("Could not connect to memcached instance.");

function memRecord($key, $value){
    global $memcache;

    if(!$memcache->get("cb_" . $key)) {
        $memcache->set("cb_" . $key, $value);
    }
}

// Records a pageview
// Type: string representing page name
// Id: Represents unique identifier of page
// Current: Current database-known value
function recordPageview($type, $id, $current){
    global $memcache;

    if ($memcache->get("cb_pageview_" . $type . "_" . strval($id))){
        $delta = ($memcache->get("cb_pageview_" . $type . "_" . strval($id)) - $current);

        error_log("cb_pageview_" . $type . "_" . strval($id) . " = " . strval($delta) . "\n", 3, "/var/log/httpd/error_log");

        // Check to see if value has hit minimum storage threshold
        if ($delta > 10){
            // Reset counter
            memRecord("cb_pageview_" . $type . "_" . strval($id), intval($current));
            // Return change
            return $delta;
        }
    }

    // Increment value
    $memcache->increment("cb_pageview_" . $type . "_" . strval($id), 1, intval($current));

    return 0;
}
*/

// Check for cookie and validate
if (isset($_COOKIE["login"])){
    // Get value stored in cookie, escape it for mysql
    $cookie = escape(trim($_COOKIE["login"]));

    // Check to see if the requirements for a cookie are being met
    if (strlen($cookie) == 32 && isset($_COOKIE["login"])){
        // Check the cookie to see if a user has it
        if (checkCookie()){
            // This cookie is in use by a user, log in as that user
            $isLoggedIn = true;

            // Load information about the user
            $user = getArray("SELECT * FROM `private_users` WHERE  `cookie` ='" . $cookie . "' LIMIT 0 , 1");

            // Store userid for easier reference
            $userId = $user["id"];

            // Load additional information about the user, and append it to the $user variable array
            $user += getArray("SELECT * FROM (SELECT COUNT(`id`) AS `messages` FROM `private_messages` WHERE `receiverId` ='$userId' AND `seen` =0 AND `deleted` =0) A,
                                             (SELECT `permissions` FROM `private_users` WHERE `id` ='$userId' LIMIT 0, 1) B");

            // Update last visit time for this user
            query("UPDATE `private_users` SET `lastTime` = now() WHERE `id` = '$userId';");
        }else{
            // Bad cookie -- force reset it
            cookie("login", "", 0);
        }
    }else{
        // Bad cookie -- force reset it
        cookie("login", "", 0);
    }
}

// Returns whether or not the cookie is valid
function checkCookie(){
    global $cookie;

    // Check database to see if a user exists with this cookie
    if (getSingleValue("SELECT COUNT(`id`) FROM  `private_users` WHERE  `cookie` ='" . $cookie . "' LIMIT 0 , 1") != 1){
        // Some user has this cookie, it is valid
        return false;
    }else{
        // Nobody has this cookie, therefore it's invalid
        return true;
    }
}

// Simple helper function to set cookies for this domain
function cookie($name, $value, $time){
    setCookie($name, $value, $time, "/", "www.cubebomb.com");
}
?>
